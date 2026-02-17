<?php

namespace App\Http\Controllers;


use App\Services\BrowserRenderService;
use App\Services\YandexHtmlParserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class YandexParserController extends Controller
{

    protected BrowserRenderService $browser;

    public function __construct(BrowserRenderService $browser)
    {
        $this->browser = $browser;
    }


    public function get(Request $request): JsonResponse
    {

        $data = [
            'request' => $request->all(),
            'status' => 'success',
            'message' => 'Данные получены',
            'data' => [] // пример данных
        ];

        $html = $this->get_from_api($request->url);

        $parser = new YandexHtmlParserService();
        $data['data'] = $parser->parsingComponyFromMaps($html['html']);

        return response()->json($data);
    }

    public function get_from_api(string $url, bool $refresh = false): array
    {

        if (!$url || !str_contains($url, 'yandex.')) {
            throw new \InvalidArgumentException('Неверная или отсутствующая ссылка');
//            return response()->json([
//                'success' => false,
//                'error' => 'Неверная или отсутствующая ссылка. Должна быть с Яндекс.Карт',
//            ], 400);
        }

        // Нормализуем ссылку — всегда на вкладку отзывов
        if (!str_ends_with($url, '/reviews/')) {
            $url = rtrim($url, '/') . '/reviews/';
        }


        $cacheKey = 'yandex_parse_' . md5($url);

        if ($refresh) Cache::forget($cacheKey);
//        if (1 == 1) Cache::forget($cacheKey);

        $html = Cache::remember($cacheKey,
//            now()->addHours(6),
            now()->addMinute(30),
            function () use ($url) {

                $html = Http::timeout(120)->post('http://parser:3000/html', [
                    'url' => $url
                ])
                ->json()
//                ->array()
                ;

                return $html;

            });

        return (array) $html;
//        return response()->json($html);
    }

}
