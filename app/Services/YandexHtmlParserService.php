<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\Client as PantherClient;
use Illuminate\Support\Facades\Log;
use Exception;

class YandexHtmlParserService
{

    public function parsingComponyFromMaps(string $html, array $options = []) // : string
    {

        try {

            $error = [];

            // Парсим полученный HTML
            $crawler = new Crawler($html);


//            $name = $crawler->filter('meta[itemprop="name"]')->text();
            $name = $crawler->filter('.orgpage-header-view__header')->text();

            $reviews = $this->extractReviews($crawler);


            // Извлекаем рейтинг и количество отзывов
            $ratingNode = $crawler->filter('.business-rating-badge-view__rating-text');
            $rating = $ratingNode->count() ? trim($ratingNode->text()) : null;

            $countNode = $crawler->filter('.business-rating-amount-view__text, .business-rating-amount-view__count');
            $reviewCount = $countNode->count() ? trim($countNode->text()) : null;

            if( 1 == 2 ){

            try {
                $reviews0 = $crawler->filter('.business-reviews-card-view__review')
                    ->each(function (Crawler $node) {
                        $html = $node->html();
                        $data = $this->parseYandexReviewBlock($node);
//                        return $this->parseYandexReviewBlock($node);
                        return compact('data', 'html');
                    });
            } catch (Exception $e) {
//                Log::error($e->getMessage());
                $error[] = $e->getFile() . ' #' . $e->getLine() . ' ' . $e->getMessage();
            }
            }

            // Извлекаем отзывы
            if(1==2) {
                $reviews = $crawler->filter('.business-reviews-card-view__review')->each(function (Crawler $node) {

                    $data = $this->parseYandexReviewBlock($node);

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

                    return compact('author', 'rating', 'date', 'text', 'data');
//                return ['author' => $author, 'rating' => $rating, 'date' => $date, 'text' => $text ];
                });


                // Фильтруем пустые отзывы
                // $reviews = array_filter($reviews, fn($r) => !empty($r['text']));
            }

            if( 1 == 2 ) {
                $spoilerTexts = $crawler->filter('.spoiler-view__text-container')->each(function (Crawler $node) {
                    // Чистый текст без лишних пробелов
                    return preg_replace('/\s+/', ' ', trim($node->text()));
                });
            }

            $ratingBlock = $crawler->filter('.business-summary-rating-badge-view__rating');

            $rating = null;
            if ($ratingBlock->count() > 0) {
                $rating = trim(preg_replace('/\s+/', ' ', $ratingBlock->text()));
                $rating = preg_replace('/\s*из\s*\d+.*$/i', '', $rating);
//                $rating = str_replace(['Rating ','Рейтинг '], ['',''], $rating);
                if (preg_match('/\b(\d+)\,?(\d*)\b/', $rating, $matches)) {
                    $rating = $matches[1] . '.' . $matches[2]; // например, "4.5"
                }
            }

            $businesAspects = $crawler->filter('.business-aspect-view')->each(function (Crawler $node) {
                // Чистый текст без лишних пробелов
                return preg_replace('/\s+/', ' ', trim($node->text()));
            });

            return response()->json([
                'success' => true,

                'name' => $name,
                'rating' => $rating,
                'businesAspects' => $businesAspects,


                'reviews' => $reviews,
//                'review_count' => count($spoilerTexts),
                'review_count' => count($reviews),
//                'reviews' => $spoilerTexts ?? [],
//                'reviews11' => $reviews ?? [],
//                'reviews00' => $reviews0 ?? [],
//                'reviews' => array_values($reviews), // переиндексируем массив
//                'loaded_count' => count($reviews),

                'timestamp' => now()->toDateTimeString(),
                'error' => $error,
                'html' => $crawler->html(),
            ]);

        } catch (\Exception $e) {

            Log::error('Panther parsing error: ' . $e->getMessage(), [
//                'url' => $url,
            ]);

            return response()->json([
//            return [
                'success' => false,
                'error' => $e->getFILe().' '.$e->getLine().''. $e->getMessage(),
//            ];
            ]);

        }

    }

    public function parseYandexReviewBlock(Crawler $reviewNode): array
    {
        $data = [];

        // 1. Автор
        $data['author'] = $reviewNode->filter('.business-review-view__author-name span[itemprop="name"]')->text('', true) ?: null;

        // 2. Аватар автора (url)
        $avatarStyle = $reviewNode->filter('.business-review-view__user-icon .user-icon-view__icon')->attr('style', '');
        if (preg_match("/url\(['\"]?([^'\"]+)['\"]?\)/", $avatarStyle, $m)) {
            $data['author_avatar'] = $m[1];
        }
        // или из meta
        $data['author_avatar_meta'] = $reviewNode->filter('meta[itemprop="image"]')->attr('content', null);

        // 3. Уровень знатока / caption
        $data['author_level'] = $reviewNode->filter('.business-review-view__author-caption')->text('', true) ?: null;

        // 4. Рейтинг (число)
        $data['rating'] = (float)$reviewNode->filter('meta[itemprop="ratingValue"]')->attr('content', null);

        // 5. Дата отзыва (человеческая + iso)
        $data['date_human'] = $reviewNode->filter('.business-review-view__date span')->text('', true) ?: null;
        $data['date_iso'] = $reviewNode->filter('meta[itemprop="datePublished"]')->attr('content', null);

        // 6. Текст отзыва (самый важный блок)
        $textNode = $reviewNode->filter('.business-review-view__body .spoiler-view__text-container');
        $data['text'] = $textNode->count()
            ? trim($textNode->text('', true))
            : $reviewNode->filter('.business-review-view__body')->text('', true);

        // 7. Картинки из карусели (самые свежие ссылки, обычно /S — маленькие, можно заменить на /XL или /XXL)
        $data['photos'] = $reviewNode
            ->filter('.business-review-media__item-img')
            ->each(fn(Crawler $img) => $img->attr('src', null));

        // 8. Лайки / полезно
        $data['likes'] = (int)$reviewNode->filter('.business-reactions-view__container[aria-label="Лайк"] .business-reactions-view__counter')->text('0');

        // 9. Дизлайки (редко, но вдруг)
        $data['dislikes'] = (int)$reviewNode->filter('.business-reactions-view__container[aria-label="Дизлайк"] .business-reactions-view__counter')->text('0');

        // 10. Есть ли ответ от организации?
        $data['has_organization_reply'] = $reviewNode->filter('.business-review-view__comment-expand')->count() > 0;

        // Опционально: ссылка на профиль автора
        $data['author_profile_url'] = $reviewNode->filter('.business-review-view__author-name a')->attr('href', null);

//        return array_filter($data, fn($v) => $v !== null && $v !== ''); // убираем пустые
        return $data; // убираем пустые
    }

    public function extractReviews( Crawler $crawler ): array
    {

        $reviewNodes = $crawler->filterXPath('//div[@itemprop="review"]');

        $reviews = [];

        foreach ($reviewNodes as $domElement) {
            $node = new Crawler($domElement); // оборачиваем каждый элемент в Crawler

            $date = $node->filter('meta[itemprop="datePublished"]')->attr('content', null);

            $reviews[] = [
                'author' => $node->filter('[itemprop="author"] [itemprop="name"]')->text(null, true) ?? null,
                'rating' => $node->filter('meta[itemprop="ratingValue"]')->attr('content', null),
                'date' => date( 'd.m.Y H:i', strtotime($date)),
                'text' => $node->filter('[itemprop="reviewBody"]')->text(null, true) ?? null,
                // можно добавить фото, лайки и т.д. как в твоей функции
            ];
        }

        return $reviews;
    }

}
