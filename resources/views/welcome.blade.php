<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet">

    <!-- Scripts -->
    {{--        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])--}}
    {{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    {{--        @routes--}}
    {{--        @inertiaHead--}}

    <Style>
        @keyframes gradientX {
            0% {
                background-position: 0% 10%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 10%;
            }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradientX 10s ease infinite;
        }
    </Style>

</head>
<body class="font-sans animate-gradient-x min-h-[99vh]
    antialiased bg-gradient-to-br
    from-blue-200 to-yellow-200">

<div class="container mx-auto">
    <h2 class="mt-10">Тестовый Laravel стенд <img src="/img/cat.png" class="inline max-h-[3rem] mx-2"/>Сергея Бакланова
        <a href="https://php-cat.com" target="_blank" class="underline text-blue-600">php-cat.com</a></h2>
    <p><a href="https://php-cat.com" target="_blank" class="underline text-blue-600">
            GitHub код этого сайта со всеми блоками
        </a></p>

    <div class="w-full flex flex-row flex-wrap xitems-center justify-center mt-10">

        <div class="w-64 min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b>Модель Товары + API + swager</b>

            <p><a href="/api/documentation" target="_blank" class="underline text-blue-600">Переход в swagger</a> покликать API,
                ключевая модель Product (остальные прицепом появились из других тест
                заданий), слоёная структура проекта контроллер, сервис, репозиторий</p>

        </div>

        <div class="w-64 min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b>vue3 играем в судоку!</b>

            <p><a href="/sudoku/" class="underline text-blue-600" target="_blank">Играть в судоку</a></p>
                <p>Создать судоку в которое играть норм</p>
                <p>Есть тех долг небольшой, функционал меня как игрока устраивает</p>

        </div>


        <div class="w-64 min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-yellow-400 p-1 rounded">Идёт разработка</span>
            <b>vue3 + получение инфы о компании с яндекс карт</b>

            <p><a href="/vue3/" class="underline text-blue-600" target="_blank">Переход в vue3 приложение</a></p>
            <p>Получаем ссылку на компанию и показываем оценку и отзывы</p>

        </div>

    </div>
</div>

</body>
</html>
