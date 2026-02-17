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


            return [
                'success' => true,

                'rating' => $rating,
                'businesAspects' => $businesAspects,
                'review_count' => count($spoilerTexts),
                'reviews' => $spoilerTexts,

//                'html' => $crawler->html(),

//                'reviews' => array_values($reviews), // переиндексируем массив
//                'loaded_count' => count($reviews),

                'timestamp' => now()->toDateTimeString(),
            ];

        } catch (\Exception $e) {

            Log::error('Panther parsing error: ' . $e->getMessage(), [
//                'url' => $url,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];

        }

    }
}
