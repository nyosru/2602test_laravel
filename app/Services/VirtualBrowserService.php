<?php

namespace App\Services;

use Symfony\Component\Panther\Client as PantherClient;
use Illuminate\Support\Facades\Log;
use Exception;

class VirtualBrowserService
{
    /**
     * Получает полный HTML страницы через headless Chrome
     *
     * @param string $url Адрес страницы
     * @param array $options Дополнительные параметры
     *   - wait_selector: CSS-селектор, которого ждём (по умолчанию body)
     *   - wait_timeout: таймаут ожидания в секундах
     *   - scroll_count: сколько раз прокрутить вниз
     *   - scroll_wait: пауза после каждого скролла
     * @return string HTML-код страницы
     * @throws Exception
     */
    public function getPageHtml(string $url, array $options = []): string
    {
        $defaultOptions = [
            'wait_selector' => 'body',          // что ждём для подтверждения загрузки
            'wait_timeout' => 30,
            'scroll_count' => 0,               // по умолчанию без скролла
            'scroll_wait' => 2,
        ];

        $options = array_merge($defaultOptions, $options);

        try {
            $client = $this->createPantherClient();

            // Открываем страницу
            $crawler = $client->request('GET', $url);

            // Ждём появления ключевого элемента
            $client->waitFor($options['wait_selector'], $options['wait_timeout'] * 1000);

            // Прокрутка страницы (для подгрузки AJAX-контента, например отзывов)
            for ($i = 0; $i < $options['scroll_count']; $i++) {
                $client->executeScript('window.scrollTo(0, document.body.scrollHeight);');
                sleep($options['scroll_wait']);
            }

            // Получаем финальный HTML
            $html = $client->getInternalResponse()->getContent();

            $client->quit();

            return $html;

        } catch (Exception $e) {
            if (isset($client)) {
                $client->quit();
            }

            Log::error('VirtualBrowser failed', [
                'url' => $url,
                'options' => $options,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception("Не удалось получить HTML страницы: " . $e->getMessage());
        }
    }

    /**
     * Создаёт Panther-клиент с настройками, оптимизированными для Docker
     */
    protected function createPantherClient(): PantherClient
    {

        $port = 9515 + random_int(1000, 9000);

        return PantherClient::createChromeClient(
            '/usr/bin/chromedriver',  // путь внутри контейнера
            [
                '--headless=new',
                '--no-sandbox',
                '--disable-dev-shm-usage',              // ← критично в Docker
                '--disable-gpu',
                '--window-size=1920,1080',
                '--disable-extensions',
                '--disable-setuid-sandbox',
                '--remote-debugging-port=9222',
                '--user-data-dir=/tmp/chrome-' . uniqid(), // уникальный каждый раз
                '--disable-crash-reporter',
                '--disable-logging',
                '--log-level=3',
                '--disable-software-rasterizer',        // ← часто помогает
                '--disable-in-process-stack-traces',
                '--no-zygote',                          // ← добавь, если крашит
                '--single-process',                     // ← экспериментально
                '--disable-background-networking',
                '--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
            ],
            [
                'chrome' => [
                    'binary' => '/usr/bin/chromium-browser', // правильный путь в Debian/Ubuntu
                ],
                'chromedriver_arguments' => [
                    "--port=$port",
                    '--verbose',
                    '--log-path=/tmp/chromedriver.log',
                    '--whitelisted-ips=',
                ],
            ]
        );
    }
}
