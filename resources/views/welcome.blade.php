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

    <Style>
        @keyframes gradientX {
            0% {
                background-position: 60% 70%;
            }
            30% {
                background-position: 30% 65%;
            }
            70% {
                background-position: 25% 60%;
            }
            100% {
                background-position: 60% 70%;
            }
        }

        .animate-gradient-x {
            background-size: 300% 300%;
            animation: gradientX 20s ease infinite;
        }
    </Style>

</head>
<body class="font-sans animate-gradient-x min-h-[99vh]
    antialiased
{{--    bg-gradient-to-br--}}
{{--    from-blue-200 to-yellow-200--}}

{{--     bg-[--}}
{{--        repeating-linear-gradient(45deg,--}}
{{--         theme(colors.blue.200),--}}
{{--         theme(colors.blue.200)_10px,--}}
{{--         theme(colors.yellow.200)_10px,--}}
{{--         theme(colors.yellow.200)_20px)--}}
{{--     ]--}}

    "

      style="
        background-image: repeating-radial-gradient(
            #ffe79c,
            #bfdbfe 1250px,
            #f8f8ea 1500px,
            #ffe79c 2000px
        );
        "
>

<div class="container mx-auto">

    <div class="text-2xl">
    <h2 class="mt-10">Тестовый Laravel стенд <img src="/img/cat.png" class="inline max-h-[3rem] mx-2"/>Сергея Бакланова
        <a href="https://php-cat.com" target="_blank" class="underline text-blue-600">php-cat.com</a></h2>
    <p><a href="https://github.com/nyosru/2602test_laravel" target="_blank" class="underline text-blue-600">
            GitHub код этого сайта со всеми блоками
        </a></p>
    </div>

    <div class="w-full text-lg flex flex-row flex-wrap xitems-center justify-center mt-10">

        <div class="
        w-1/3
        min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b>Модель Товары + API + swager</b>

            <p><a href="/api/documentation" target="_blank" class="underline text-blue-600">Переход в&nbsp;swagger</a>
                покликать API,
                ключевая модель Product (остальные прицепом появились из&nbsp;других тест
                заданий), слоёная структура проекта контроллер, сервис, репозиторий</p>

        </div>

        <div class="
        w-1/3
         min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b>vue3 играем в&nbsp;судоку!</b>

            <p><a href="/sudoku/" class="underline text-blue-600" target="_blank">Играть в&nbsp;судоку</a></p>
            <p>Создать судоку в&nbsp;которое играть норм</p>
            <p>Есть тех долг небольшой, функционал меня как игрока устраивает</p>

        </div>


        <div class="
        w-1/3
         min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b class="">vue3 + получение инфы о&nbsp;компании с&nbsp;яндекс карт</b>

            <p><a href="/vue3/" class="underline text-blue-600" target="_blank">Переход в&nbsp;vue3 приложение</a></p>
            <p>Получаем ссылку на&nbsp;компанию и&nbsp;показываем оценку и&nbsp;отзывы</p>

        </div>


        <div class="
        w-1/3
        min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">

            <div>
                <b>GitHub</b>
            </div>
            <img src="/img/github.png" class="float-left w-1/4 mr-2"/>
            <p><a href="https://github.com/nyosru" class="underline text-blue-600" target="_blank">репозитории в GitHub</a></p>
            <p>весь код хранится в&nbsp;гите, автоматизация ci/cd экономят массу времени для&nbsp;обновления протестированного кода на&nbsp;серверах в&nbsp;тест и&nbsp;прод окружении</p>

        </div>

        <div class="
        w-1/3
        min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">

            <div>
                <b>Пакеты composer в&nbsp;Packagist</b>
            </div>
            <img src="/img/logo-composer.png" class="float-left w-1/4 mr-2"/>
            <p><a href="https://packagist.org/users/Nyos/packages/" class="underline text-blue-600" target="_blank">nyos
                    в Packagist</a></p>
            <p>пишу композер пакеты, версионирование, сложные связки оч.удобно хранить
                и&nbsp;использовать</p>

        </div>

    </div>
</div>

</body>
</html>
