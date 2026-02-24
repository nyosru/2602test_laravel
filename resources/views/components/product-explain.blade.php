<div class="mt-10 p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
    <span class="float-right bg-blue-400 text-white px-2 py-1 rounded text-xs">EXPLAIN Product query</span>

    <h3 class="font-bold mb-2">Пример visual EXPLAIN сложного запроса к Product</h3>

    <p class="mb-3 text-sm text-gray-700">
        Ниже — пример чуть более сложного Eloquent‑запроса к модели <code>Product</code> с вычисляемым полем,
        фильтрами и сортировкой. Пакет <code>tpetry/laravel-mysql-explain</code> отправляет EXPLAIN этого запроса
        на сервис <code>mysqlexplain.com</code> и возвращает удобную ссылку для анализа плана выполнения.
    </p>

    <div class="mb-3">
        <p class="font-semibold text-sm mb-1">SQL‑запрос:</p>
        <pre class="text-xs bg-gray-100 rounded p-2 overflow-x-auto">{{ $sql }}</pre>
    </div>

    <div class="mb-3">
        <p class="font-semibold text-sm mb-1">Bindings:</p>
        <pre class="text-xs bg-gray-100 rounded p-2 overflow-x-auto">{{ json_encode($bindings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
    </div>

    <div class="mt-4">
        <a href="{{ $visualExplainUrl }}" target="_blank"
           class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded">
            Открыть visual EXPLAIN плана запроса
        </a>
        <p class="mt-2 text-xs text-gray-500">
            Ссылка ведёт на <span class="underline">mysqlexplain.com</span> и показывает наглядный план выполнения EXPLAIN.
        </p>
    </div>
</div>

