<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Exception;
use Illuminate\Support\Facades\Log;

class BrowserRenderService
{

    /**
     * Получает HTML страницы после полной отрисовки JS
     */
    public function getRenderedHtml(
        string $url,
        string $waitSelector = null,
        int $timeoutMs = 30000,
        int $scrollCount = 0,
        int $scrollPauseSec = 3
    ): string {
        try {
            $shot = Browsershot::url($url)
                ->noSandbox()                           // обязательно в Docker
                ->disableGpu()
                ->windowSize(1920, 1080)
                ->waitUntilNetworkIdle()
                ->timeout($timeoutMs);

            if ($waitSelector) {
                $shot->waitForSelector($waitSelector, ['timeout' => $timeoutMs]);
            }

            // Скролл для подгрузки контента
            if ($scrollCount > 0) {
                $shot->evaluateScript(
                    collect(range(1, $scrollCount))
                        ->map(fn() => 'window.scrollTo(0, document.body.scrollHeight);')
                        ->join('; sleep(' . $scrollPauseSec . '); ')
                );
            }

            return $shot->bodyHtml();

        } catch (Exception $e) {
            Log::error('Browsershot render failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

}
