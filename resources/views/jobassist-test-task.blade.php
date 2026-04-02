<main class="test_logistic">

    <div class="container mx-auto">
        <style>

            p.lead {
                margin: 0 auto;
                max-width: 720px;
                font-size: 18px;
                line-height: 1.6;
                color: var(--muted);
            }

            ul,
            ol {
                margin: 0;
                padding-left: 20px;
                display: grid;
                gap: 10px;
                line-height: 1.7;
                font-size: 17px;
            }

            code {
                background: rgba(46, 125, 255, 0.12);
                padding: 2px 6px;
                border-radius: 6px;
                font-family: "JetBrains Mono", "Fira Code", monospace;
                font-size: 0.95em;
            }

            pre {
                margin: 0;
                padding: 16px 20px;
                background: rgba(46, 125, 255, 0.08);
                border-radius: 14px;
                overflow-x: auto;
                font-family: "JetBrains Mono", "Fira Code", monospace;
                font-size: 0.95em;
                line-height: 1.6;
            }

            .callout {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .meta-line {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                align-items: baseline;
            }

            .meta-label {
                font-weight: 600;
                color: var(--muted);
                letter-spacing: 0.01em;
            }

            .sub-list {
                margin-top: 4px;
            }


            .test_logistic section {
                background: var(--card-bg);
                border-radius: 18px;
                padding: 32px;
                border: 1px solid rgba(46, 125, 255, 0.08);
                box-shadow: 0 16px 40px rgba(31, 36, 48, 0.08);
                display: flex;
                flex-direction: column;
                gap: 18px;
            }


            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
            }


        </style>

        <section aria-labelledby="context">
            <h1>Тестовое задание</h1>
            <p class="lead">
                Реализуйте минимальный API бронирования слотов с горячим кешем и защитой от оверсела.
                Ниже — подробный бриф с требованиями и ожидаемыми результатами.
            </p>
        </section>

        <section aria-labelledby="context">
            <h2 id="context">📘 Контекст</h2>
            <p>
                Вы проектируете сервис, который управляет бронью слотов (складские окна, доставка или время приема
                клиентов). Каждый слот имеет ограниченную вместимость, пользователи могут создавать временные холды, а
                затем подтверждать их. Нужно обеспечить корректную работу под нагрузкой: горячий кеш, транзакции, защита
                от оверсела.
            </p>
        </section>

        <section aria-labelledby="requirements">
            <h2 id="requirements">⚙️ Функциональные требования</h2>
            <ol>
                <li>
                    <strong>Получение доступных слотов</strong>
                    <div class="callout">
                        <div class="meta-line">
                            <span class="meta-label">Метод:</span>
                            <code>GET /slots/availability</code>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Пример ответа:</span>
                        </div>
                        <pre><code>[
  { "slot_id": 1, "capacity": 10, "remaining": 6 },
  { "slot_id": 2, "capacity": 5, "remaining": 0 }
]</code></pre>
                    </div>
                    <ul class="sub-list">
                        <li>Кешировать результат на 5–15 секунд, предусмотреть защиту от cache stampede.</li>
                        <li>После подтверждения или отмены данных инвалидировать кеш.</li>
                    </ul>
                </li>
                <li>
                    <strong>Создание холда</strong>
                    <div class="callout">
                        <div class="meta-line">
                            <span class="meta-label">Метод:</span>
                            <code>POST /slots/{id}/hold</code>
                        </div>
                        <div class="meta-line">
                            <span class="meta-label">Заголовок:</span>
                            <code>Idempotency-Key: &lt;UUID&gt;</code>
                        </div>
                    </div>
                    <ul class="sub-list">
                        <li>Создает запись в таблице <code>holds</code> со статусом <code>held</code>.</li>
                        <li>Проверяет доступность мест и возвращает <code>409 Conflict</code>, если capacity исчерпан.
                        </li>
                        <li>Повторный запрос с тем же ключом возвращает прежний результат (идемпотентность).</li>
                        <li>Холды живут 5 минут (фоновую очистку можно не реализовывать).</li>
                    </ul>
                </li>
                <li>
                    <strong>Подтверждение холда</strong>
                    <div class="callout">
                        <div class="meta-line">
                            <span class="meta-label">Метод:</span>
                            <code>POST /holds/{id}/confirm</code>
                        </div>
                    </div>
                    <ul class="sub-list">
                        <li>Переводит холд в состояние <code>confirmed</code>.</li>
                        <li>Атомарно уменьшает <code>remaining</code> в слоте на 1 с защитой от оверсела.</li>
                        <li>При отсутствии мест возвращает <code>409 Conflict</code>.</li>
                        <li>После успешного подтверждения инвалидирует кеш доступности.</li>
                    </ul>
                </li>
                <li>
                    <strong>Отмена холда</strong>
                    <div class="callout">
                        <div class="meta-line">
                            <span class="meta-label">Метод:</span>
                            <code>DELETE /holds/{id}</code>
                        </div>
                    </div>
                    <ul class="sub-list">
                        <li>Меняет состояние холда на <code>cancelled</code>.</li>
                        <li>Возвращает слот в доступ, обновляя остаток.</li>
                        <li>Инвалидирует кеш доступных слотов.</li>
                    </ul>
                </li>
            </ol>
        </section>

        <section aria-labelledby="stack">
            <h2 id="stack">✅ Ожидаемые результаты</h2>
            <ul>
                <li>Код на Laravel 12 (PHP 8.2+) и MySQL 8+.</li>
                <li>Маршруты определены в <code>routes/api.php</code>.</li>
                <li>Контроллеры: <code>AvailabilityController</code>, <code>HoldController</code>.</li>
                <li>Сервисный слой: <code>SlotService</code> (транзакции, кеш, идемпотентность).</li>
                <li>Минимальные миграции для таблиц слотов и холдов.</li>
                <li>
                    README с инструкциями запуска (<code>php artisan migrate</code>, <code>php artisan serve</code>) и
                    примерами <code>curl</code>-запросов (создание холда, повтор с тем же ключом, подтверждение, отмена,
                    конфликт при оверселе).
                </li>
            </ul>
        </section>

        <section aria-labelledby="extras">
            <h2 id="extras">➕ Дополнительные требования</h2>
            <ul>
                <li>Запись экрана с голосовыми пояснениями во время реализации (подготовка и планирование заранее
                    приветствуются).
                </li>
                <li>Готовое видео загрузить на Яндекс.Диск, открыть доступ для **@yandex.ru.</li>
                <li>В письме указать ссылку на видео, а также репозиторий с финальным кодом.</li>
            </ul>
        </section>

        <section aria-labelledby="actions">
            <h2 id="actions">🚀 Что сделать кандидатy</h2>
            <ol>
                <li>Изучите требования и спланируйте архитектуру сервиса.</li>
                <li>Реализуйте API с учетом кеша, транзакций и идемпотентности.</li>
                <li>Запишите видео процесса разработки с комментариями.</li>
                <li>Подготовьте README и примеры запросов.</li>
                <li>
                    Выложите видео и репозиторий, отправьте ссылки на
                    **@yandex.ru
                    с темой письма «Видео-вакансия — результат - ФИО».
                </li>
                <li>Срок выполнения: 10 дней со дня получения письма с ссылкой на задание.</li>
            </ol>
        </section>


        <br/>
        видео лайв кодинга
        <br/>
        <br/>
        часть1
        <br/>
        <iframe src="https://vkvideo.ru/video_ext.php?oid=-73827323&id=456239037&hash=135d26ed1f67822e&hd=1" width="640"
                height="360" allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;"
                frameborder="0" allowfullscreen></iframe>
        <br/>
        <br/>
        часть 2
        <br/>
        <iframe src="https://vkvideo.ru/video_ext.php?oid=-73827323&id=456239038&hash=53d06365b529d0b8&hd=1" width="640"
                height="360" allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;"
                frameborder="0" allowfullscreen></iframe>

    </div>
</main>
