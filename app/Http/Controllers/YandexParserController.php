<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

//use Illuminate\Http\Request;
//use Symfony\Component\Panther\Client;
//use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Panther\Client as PantherClient;
use Illuminate\Support\Facades\Cache;

class YandexParserController extends Controller
{
    public function get(Request $request)
    {

        $data = [
            'request' => $request->all(),
            'status' => 'success',
            'message' => 'Данные получены',
            'data' => [1, 2, 3] // пример данных
        ];

//        $data['data'] = $this->get_from_key( $request->url );
//        $data['data'] = $this->get_from_crawler( $request->url );
        $data['data'] = $this->get_from_panther($request->url);

        return response()->json($data);
    }

    public function get_from_key(string $url)
    {
//        $url = $request->input('url');

        // Извлекаем ID организации
        preg_match('/\/org\/[^\/]+\/(\d+)/', $url, $m);
        $orgId = $m[1] ?? null;

        if (!$orgId) {
            return response(['error' => 'Не удалось извлечь ID организации'], 400);
        }

        $apiKey = env('YANDEX_MAPS_API_KEY'); // получить здесь: https://developer.tech.yandex.ru/

        $response = Http::get('https://search-maps.yandex.ru/v1/', [
            'apikey' => $apiKey,
            'text' => $orgId,
            'type' => 'biz',
            'lang' => 'ru_RU',
            'results' => 1,
        ]);

        if ($response->failed()) {
            return response(['error' => 'Ошибка API', 'details' => $response->body()], 500);
        }

        $data = $response->json();

        $company = $data['features'][0]['properties']['CompanyMetaData'] ?? null;

        if (!$company) {
            return response(['error' => 'Организация не найдена'], 404);
        }

        return [
            'name' => $company['name'] ?? null,
            'address' => $company['address'] ?? null,
            'phones' => $company['Phones'] ?? [],
            'site' => $company['url'] ?? null,
            'schedule' => $company['Hours']['text'] ?? null,
            'rating' => $company['rating']['value'] ?? null,
            'review_count' => $company['rating']['reviewCount'] ?? $company['review_count'] ?? null,
            'categories' => collect($company['Categories'] ?? [])->pluck('name')->toArray(),
            // и другие поля...
        ];
    }

    public function get_from_crawler(string $url)
    {

        // Если ссылка на /reviews/, оставляем как есть
        // Если обычная карточка — добавляем /reviews/
        if (!str_contains($url, '/reviews/')) {
            $url = rtrim($url, '/') . '/reviews/';
        }

        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept-Language' => 'ru-RU,ru;q=0.9',
            ],
            'timeout' => 30,
        ]);

        try {

            $response = $client->get($url);
            $html = (string)$response->getBody();

            $crawler = new Crawler($html);

            // Рейтинг и количество отзывов (примерные селекторы — проверяйте DevTools!)
            $ratingText = $crawler->filter('.business-rating-badge-view__rating-text')->first()->text() ?? null;
            $reviewsCount = $crawler->filter('.business-rating-amount-view__text')->first()->text() ?? null;

            // Отзывы
            $reviews = $crawler->filter('.business-reviews-card-view__review')->each(function (Crawler $node) {
                return [
                    'author' => $node->filter('.business-review-view__author')->count() ? $node->filter('.business-review-view__author')->text() : null,
                    'date' => $node->filter('.business-review-view__date')->count() ? $node->filter('.business-review-view__date')->text() : null,
                    'rating' => $node->filter('.business-rating-badge-view__rating-text')->count() ? $node->filter('.business-rating-badge-view__rating-text')->text() : null,
                    'text' => $node->filter('.business-review-view__body-text')->count() ? trim($node->filter('.business-review-view__body-text')->text()) : null,
                    'likes' => $node->filter('.business-review-view__like-button-count')->count() ? $node->filter('.business-review-view__like-button-count')->text() : null,
                ];
            });

            // Базовая информация о компании (часто в микроразметке или в шапке)
            $title = $crawler->filter('h1')->first()->text() ?? null;
            $address = $crawler->filter('.business-contacts-view__address-link')->first()->text() ?? null;

            return response([
                'title' => $title,
                'address' => $address,
                'rating' => $ratingText,
                'review_count' => $reviewsCount,
                'reviews' => array_filter($reviews, fn($r) => !empty($r['text'])),
                'total_reviews_count' => count($reviews),
            ]);

        } catch (\Exception $e) {
            return response([
                'error' => 'Ошибка парсинга',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function get_from_panther(string $url, bool $refresh = false)
    {

        if (!$url || !str_contains($url, 'yandex.ru/maps')) {
            return response()->json([
                'success' => false,
                'error' => 'Неверная или отсутствующая ссылка. Должна быть с Яндекс.Карт',
            ], 400);
        }

        // Нормализуем ссылку — всегда на вкладку отзывов
        if (!str_ends_with($url, '/reviews/')) {
            $url = rtrim($url, '/') . '/reviews/';
        }

        $cacheKey = 'yandex_parse_' . md5($url);


        if ($refresh) {
            Cache::forget($cacheKey);
        }


        $html = Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {


            try {

                // Создаём Panther-клиент с настройками для Docker
                $client = PantherClient::createChromeClient(
                    '/usr/local/bin/chromedriver',
                    [
                        '--headless=new',                     // новый headless-режим (более стабильный)
                        '--no-sandbox',
                        '--disable-dev-shm-usage',
                        '--disable-gpu',
                        '--disable-software-rasterizer',
                        '--disable-extensions',
                        '--disable-setuid-sandbox',
                        '--remote-debugging-port=9222',       // явно указываем порт
                        '--disable-background-networking',
                        '--window-size=1920,1080',
                        '--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    ],
                    [
                        'chrome' => [
                            'binary' => '/usr/bin/chromium',  // или /usr/lib/chromium-browser/chrome
                        ],
                    ]);

                // Открываем страницу
                $crawler = $client->request('GET', $url);

                // Ждём появления блока с отзывами (максимум 20 секунд)
                $client->waitFor('.business-reviews-card-view__review', 20000);

                // Прокручиваем вниз 2–3 раза, чтобы подгрузились дополнительные отзывы
                for ($i = 0; $i < 3; $i++) {
                    $client->executeScript('window.scrollTo(0, document.body.scrollHeight);');
                    sleep(3); // ждём подгрузки AJAX-контента
                }

                // Получаем полный HTML после всех действий
                $rawHtml = $client->getInternalResponse()->getContent();

                // Обязательно закрываем браузер!
                $client->quit();

                return $rawHtml;

            } catch (\Exception $e) {

                $client->quit();
                throw $e; // чтобы Cache::remember поймал исключение и не кэшировал ошибку

            }

        });

//        dump($html);

//        echo '<div style="border:2px solid red; padding: 10px;">'.$html.'</div>';

        try {

            // Парсим полученный HTML
            $crawler = new Crawler($html);

            // Извлекаем рейтинг и количество отзывов
            $ratingNode = $crawler->filter('.business-rating-badge-view__rating-text');
            $rating = $ratingNode->count() ? trim($ratingNode->text()) : null;

            $countNode = $crawler->filter('.business-rating-amount-view__text, .business-rating-amount-view__count');
            $reviewCount = $countNode->count() ? trim($countNode->text()) : null;

            // Извлекаем отзывы
            $reviews = $crawler->filter('.business-reviews-card-view__review')->each(function (Crawler $node) {
                $author = $node->filter('.business-review-view__author')->count()
                    ? trim($node->filter('.business-review-view__author')->text())
                    : null;

                $rating = $node->filter('.business-rating-badge-view__rating-text')->count()
                    ? trim($node->filter('.business-rating-badge-view__rating-text')->text())
                    : null;

                $date = $node->filter('.business-review-view__date')->count()
                    ? trim($node->filter('.business-review-view__date')->text())
                    : null;

                $text = $node->filter('.business-review-view__body-text')->count()
                    ? trim($node->filter('.business-review-view__body-text')->text())
                    : null;

                return compact('author', 'rating', 'date', 'text');
            });

            // Фильтруем пустые отзывы
            $reviews = array_filter($reviews, fn($r) => !empty($r['text']));


            $spoilerTexts = $crawler->filter('.spoiler-view__text-container')->each(function (Crawler $node) {
                // Чистый текст без лишних пробелов
                return preg_replace('/\s+/', ' ', trim($node->text()));
            });


            $ratingBlock = $crawler->filter('.business-summary-rating-badge-view__rating');

            $rating = null;
            if ($ratingBlock->count() > 0) {
                // Получаем только текст и чистим
                $rating = trim(preg_replace('/\s+/', ' ', $ratingBlock->text()));

                // Если хочешь убрать "из 5" или лишнее
                $rating = preg_replace('/\s*из\s*\d+.*$/i', '', $rating);
                $rating = str_replace('Rating ', '', $rating);
            }


            $businesAspects = $crawler->filter('.business-aspect-view')->each(function (Crawler $node) {
                // Чистый текст без лишних пробелов
                return preg_replace('/\s+/', ' ', trim($node->text()));
            });


            return response()->json([
                'success' => true,
                'url' => $url,

                'rating' => $rating,
                'businesAspects' => $businesAspects,
                'review_count' => count($spoilerTexts),
                'reviews' => $spoilerTexts,

//                'html' => $crawler->html(),

//                'reviews' => array_values($reviews), // переиндексируем массив
//                'loaded_count' => count($reviews),
                'timestamp' => now()->toDateTimeString(),
            ]);

        } catch (\Exception $e) {

            Log::error('Panther parsing error: ' . $e->getMessage(), [
                'url' => $url,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];

        }

        //    } catch (\Exception $e)
        //{
        //Log::error('Panther parsing error: ' . $e->getMessage(), ['url' => $url,
        //'trace' => $e->getTraceAsString(),]);
        //
        //return response()->json(['success' => false,
        //'error' => $e->getMessage(),
        //'hint' => 'Проверьте наличие chromium/chromedriver в контейнере и права доступа',], 500);
        //
        //}

    }

}
