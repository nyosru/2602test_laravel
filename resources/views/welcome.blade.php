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
    <p><a href="https://github.com/nyosru/2602test_laravel" target="_blank" class="underline text-blue-600">
            GitHub код этого сайта со всеми блоками
        </a></p>

    <div class="w-full flex flex-row flex-wrap xitems-center justify-center mt-10">

        <div class="w-64 min-h-[150px] p-4 bg-white rounded-lg border-2 border-gray-200 shadow-sm">
            <span class="float-right bg-green-400 p-1 rounded">Готово</span>
            <b>Модель Товары + API + swager</b>

            <p><a href="/api/documentation" target="_blank" class="underline text-blue-600">Переход в swagger</a>
                покликать API,
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


@if(1==2)
используй $crawler
делаю парсинг и ищу все такие блоки, сделай функцию которая получает всю информацию что есть в html блока

<div class="business-reviews-card-view__review" aria-posinset="7" aria-setsize="50" role="listitem">
    <div class="business-review-view" itemprop="review" itemtype="http://schema.org/Review" itemscope="">
        <div class="business-review-view__info">
            <div class="business-review-view__author-container">
                <div class="business-review-view__author-image">
                    <a role="link" class="business-review-view__user-icon"
                       href="https://yandex.com/maps/user/rb947hx2c415j87jh1c611522m"
                       target="_blank" rel="noreferrer" aria-label="Аватар">
                        <div class="user-icon-view__icon"
                             style="background-image: url(&quot;https://avatars.mds.yandex.net/get-yapic/29310/0o-6/islands-68&quot;);"></div>
                    </a></div>
                <div class="business-review-view__author-info">
                    <div class="business-review-view__author-name" itemprop="author" itemtype="http://schema.org/Person"
                         itemscope="">
                        <meta itemprop="image" content="https://avatars.mds.yandex.net/get-yapic/29310/0o-6/islands-68">
                        <a role="link" class="business-review-view__link"
                           href="https://yandex.com/maps/user/rb947hx2c415j87jh1c611522m" target="_blank"
                           rel="noreferrer"><span itemprop="name" dir="auto">Виктория Гришина</span></a></div>
                    <div class="business-review-view__author-caption">Знаток города 4 уровня</div>
                </div>
                <div class="business-review-view__subscription-control">
                    <div class="ugc-subscribe-button _status_unsubscribed">
                        <button role="button" type="button" class="button _view_secondary-blue _ui _size_small"><span
                                class="button__text">Подписаться</span></button>
                    </div>
                </div>
            </div>
            <div class="business-review-view__header">
                <div class="business-review-view__rating">
                    <div class="business-rating-badge-view _size_m _weight_medium">
                        <div aria-label="Оценка 5 Из 5" class="business-rating-badge-view__stars _spacing_normal"><span
                                tag="span" style="font-size: 0px; line-height: 0;"
                                class="inline-image _loaded icon business-rating-badge-view__star _full"
                                aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                                 clip-rule="evenodd"
                                                                                                 d="M7.985 11.65l-3.707 2.265a.546.546 0 0 1-.814-.598l1.075-4.282L1.42 6.609a.546.546 0 0 1 .29-.976l4.08-.336 1.7-3.966a.546.546 0 0 1 1.004.001l1.687 3.965 4.107.337c.496.04.684.67.29.976l-3.131 2.425 1.073 4.285a.546.546 0 0 1-.814.598L7.985 11.65z"
                                                                                                 fill="currentColor"></path></svg></span><span
                                tag="span" style="font-size: 0px; line-height: 0;"
                                class="inline-image _loaded icon business-rating-badge-view__star _full"
                                aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                                 clip-rule="evenodd"
                                                                                                 d="M7.985 11.65l-3.707 2.265a.546.546 0 0 1-.814-.598l1.075-4.282L1.42 6.609a.546.546 0 0 1 .29-.976l4.08-.336 1.7-3.966a.546.546 0 0 1 1.004.001l1.687 3.965 4.107.337c.496.04.684.67.29.976l-3.131 2.425 1.073 4.285a.546.546 0 0 1-.814.598L7.985 11.65z"
                                                                                                 fill="currentColor"></path></svg></span><span
                                tag="span" style="font-size: 0px; line-height: 0;"
                                class="inline-image _loaded icon business-rating-badge-view__star _full"
                                aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                                 clip-rule="evenodd"
                                                                                                 d="M7.985 11.65l-3.707 2.265a.546.546 0 0 1-.814-.598l1.075-4.282L1.42 6.609a.546.546 0 0 1 .29-.976l4.08-.336 1.7-3.966a.546.546 0 0 1 1.004.001l1.687 3.965 4.107.337c.496.04.684.67.29.976l-3.131 2.425 1.073 4.285a.546.546 0 0 1-.814.598L7.985 11.65z"
                                                                                                 fill="currentColor"></path></svg></span><span
                                tag="span" style="font-size: 0px; line-height: 0;"
                                class="inline-image _loaded icon business-rating-badge-view__star _full"
                                aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                                 clip-rule="evenodd"
                                                                                                 d="M7.985 11.65l-3.707 2.265a.546.546 0 0 1-.814-.598l1.075-4.282L1.42 6.609a.546.546 0 0 1 .29-.976l4.08-.336 1.7-3.966a.546.546 0 0 1 1.004.001l1.687 3.965 4.107.337c.496.04.684.67.29.976l-3.131 2.425 1.073 4.285a.546.546 0 0 1-.814.598L7.985 11.65z"
                                                                                                 fill="currentColor"></path></svg></span><span
                                tag="span" style="font-size: 0px; line-height: 0;"
                                class="inline-image _loaded icon business-rating-badge-view__star _full"
                                aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16"
                                                        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                                 clip-rule="evenodd"
                                                                                                 d="M7.985 11.65l-3.707 2.265a.546.546 0 0 1-.814-.598l1.075-4.282L1.42 6.609a.546.546 0 0 1 .29-.976l4.08-.336 1.7-3.966a.546.546 0 0 1 1.004.001l1.687 3.965 4.107.337c.496.04.684.67.29.976l-3.131 2.425 1.073 4.285a.546.546 0 0 1-.814.598L7.985 11.65z"
                                                                                                 fill="currentColor"></path></svg></span>
                        </div>
                    </div>
                    <span itemscope="" itemprop="reviewRating" itemtype="http://schema.org/Rating"><meta
                            itemprop="bestRating" content="5"><meta itemprop="worstRating" content="1"><meta
                            itemprop="ratingValue" content="5.0"></span></div>
                <span class="business-review-view__date"><span>23 октября 2024</span><meta itemprop="datePublished"
                                                                                           content="2024-10-22T19:08:28.394Z"></span>
            </div>
            <div dir="auto" class="business-review-view__body" itemprop="reviewBody"><span><!--noindex--></span><span
                    data-nosnippet="true"><div class="spoiler-view__text" style="line-height: 20px;"><span
                            class=" spoiler-view__text-container" data-original-size="59">были тут первый раз, на удивление, что все очень классно! отдельное спасибо хотелось бы сказать официанту Дарье и бармену Максиму. очень хорошое обслуживание и вкусные напитки, еда. будем приходить еще🫶🏻</span></div></span><span><!--/noindex--></span>
            </div>
            <div class="business-review-view__carousel">
                <div class="carousel _old-browsers-workaround _theme_white business-review-media _preview-size_small"
                     style="margin-left: -80px; margin-right: -80px; height: 96px;">
                    <div role="presentation" class="carousel__scrollable _smooth-scroll"
                         style="height: 117px; padding-bottom: 21px;">
                        <div role="list" class="carousel__content">
                            <div role="listitem" class="carousel__item _align_center" style="padding-left: 80px;">
                                <div aria-hidden="true" class="business-review-media__item"><img loading="lazy"
                                                                                                 class="business-review-media__item-img"
                                                                                                 draggable="false"
                                                                                                 alt=""
                                                                                                 src="https://avatars.mds.yandex.net/get-altay/13052575/2a00000192b5a1ba6651ac9546bb6bb04fda/S">
                                </div>
                            </div>
                            <div role="listitem" class="carousel__item _align_center"
                                 style="padding-right: 80px; padding-left: 12px;">
                                <div aria-hidden="true" class="business-review-media__item"><img loading="lazy"
                                                                                                 class="business-review-media__item-img"
                                                                                                 draggable="false"
                                                                                                 alt=""
                                                                                                 src="https://avatars.mds.yandex.net/get-altay/13220782/2a00000192b5a1e964071530a8aba99d15ff/S">
                                </div>
                            </div>
                            <iframe class="resize-listener" tabindex="-1" aria-hidden="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="business-review-view__actions">
                <div class="business-reactions-view">
                    <div class="business-reactions-view__container" aria-hidden="false" aria-label="Лайк" role="button"
                         aria-pressed="false" tabindex="0"><span class="business-reactions-view__icon"
                                                                 style="display: inherit;"><svg width="24" height="24"
                                                                                                viewBox="0 0 24 24"
                                                                                                xmlns="http://www.w3.org/2000/svg"><path
                                    fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22 11.5c0-2.097-1.228-3.498-3.315-3.498h-2.918c.089-.919.133-1.752.133-2.502 0-1.963-1.81-3.5-3.64-3.5-1.414 0-1.81.81-2.049 2.683-.003.03-.094.762-.125.995-.055.407-.112.77-.182 1.133-.273 1.414-.989 2.944-1.727 3.841a2.317 2.317 0 0 0-.456-.318C7.314 10.116 6.838 10 6.153 10h-.306c-.685 0-1.16.116-1.568.334a2.272 2.272 0 0 0-.945.945c-.218.407-.334.883-.334 1.568v5.306c0 .685.116 1.16.334 1.568.218.407.538.727.945.945.407.218.883.334 1.568.334h.306c.685 0 1.16-.116 1.568-.334.235-.126.441-.286.615-.477.697.525 1.68.811 2.985.811h4.452c1.486 0 2.565-.553 3.253-1.487.284-.384.407-.652.597-1.166a.806.806 0 0 1 .162-.214c.026-.028.11-.112.208-.21.135-.134.296-.295.369-.373.323-.346.576-.69.782-1.103.357-.713.406-1.258.337-2.173-.026-.35-.027-.464-.008-.542.034-.145.075-.265.147-.447l.066-.166c.22-.552.314-.971.314-1.619zm-9.932-5.555c.034-.251.129-1.018.127-1.009.062-.483.114-.768.168-.932.76.059 1.537.75 1.537 1.496 0 .955-.08 2.082-.242 3.378a1 1 0 0 0 .992 1.124h4.035c.92 0 1.315.451 1.315 1.498 0 .37-.04.547-.173.881l-.066.167a4.916 4.916 0 0 0-.234.72c-.084.356-.083.586-.04 1.156.044.582.022.822-.131 1.129a2.607 2.607 0 0 1-.455.63c-.04.044-.148.152-.262.266-.129.128-.265.264-.319.322-.266.286-.451.554-.573.882-.128.345-.192.486-.33.674-.314.425-.798.673-1.644.673H11.32c-1.833 0-2.317-.568-2.317-2v-4.35c1.31-1.104 2.458-3.356 2.864-5.46.077-.405.14-.803.2-1.245zm-6.846 6.152c.116-.061.278-.097.625-.097h.306c.347 0 .509.036.625.098a.275.275 0 0 1 .124.124c.062.116.098.277.098.625v5.306c0 .348-.036.509-.098.625a.275.275 0 0 1-.124.125c-.116.061-.278.097-.625.097h-.306c-.347 0-.509-.036-.625-.098a.275.275 0 0 1-.124-.124C5.036 18.662 5 18.5 5 18.153v-5.306c0-.348.036-.509.098-.625a.275.275 0 0 1 .124-.124z"
                                    fill="currentColor"></path></svg></span>
                        <div class="business-reactions-view__counter">4</div>
                    </div>
                    <div class="business-reactions-view__container" aria-hidden="false" aria-label="Дизлайк"
                         role="button" aria-pressed="false" tabindex="0"><span
                            class="business-reactions-view__icon _dislike" style="display: inherit;"><svg width="24"
                                                                                                          height="24"
                                                                                                          viewBox="0 0 24 24"
                                                                                                          xmlns="http://www.w3.org/2000/svg"><path
                                    fill-rule="evenodd" clip-rule="evenodd"
                                    d="M22 11.5c0-2.097-1.228-3.498-3.315-3.498h-2.918c.089-.919.133-1.752.133-2.502 0-1.963-1.81-3.5-3.64-3.5-1.414 0-1.81.81-2.049 2.683-.003.03-.094.762-.125.995-.055.407-.112.77-.182 1.133-.273 1.414-.989 2.944-1.727 3.841a2.317 2.317 0 0 0-.456-.318C7.314 10.116 6.838 10 6.153 10h-.306c-.685 0-1.16.116-1.568.334a2.272 2.272 0 0 0-.945.945c-.218.407-.334.883-.334 1.568v5.306c0 .685.116 1.16.334 1.568.218.407.538.727.945.945.407.218.883.334 1.568.334h.306c.685 0 1.16-.116 1.568-.334.235-.126.441-.286.615-.477.697.525 1.68.811 2.985.811h4.452c1.486 0 2.565-.553 3.253-1.487.284-.384.407-.652.597-1.166a.806.806 0 0 1 .162-.214c.026-.028.11-.112.208-.21.135-.134.296-.295.369-.373.323-.346.576-.69.782-1.103.357-.713.406-1.258.337-2.173-.026-.35-.027-.464-.008-.542.034-.145.075-.265.147-.447l.066-.166c.22-.552.314-.971.314-1.619zm-9.932-5.555c.034-.251.129-1.018.127-1.009.062-.483.114-.768.168-.932.76.059 1.537.75 1.537 1.496 0 .955-.08 2.082-.242 3.378a1 1 0 0 0 .992 1.124h4.035c.92 0 1.315.451 1.315 1.498 0 .37-.04.547-.173.881l-.066.167a4.916 4.916 0 0 0-.234.72c-.084.356-.083.586-.04 1.156.044.582.022.822-.131 1.129a2.607 2.607 0 0 1-.455.63c-.04.044-.148.152-.262.266-.129.128-.265.264-.319.322-.266.286-.451.554-.573.882-.128.345-.192.486-.33.674-.314.425-.798.673-1.644.673H11.32c-1.833 0-2.317-.568-2.317-2v-4.35c1.31-1.104 2.458-3.356 2.864-5.46.077-.405.14-.803.2-1.245zm-6.846 6.152c.116-.061.278-.097.625-.097h.306c.347 0 .509.036.625.098a.275.275 0 0 1 .124.124c.062.116.098.277.098.625v5.306c0 .348-.036.509-.098.625a.275.275 0 0 1-.124.125c-.116.061-.278.097-.625.097h-.306c-.347 0-.509-.036-.625-.098a.275.275 0 0 1-.124-.124C5.036 18.662 5 18.5 5 18.153v-5.306c0-.348.036-.509.098-.625a.275.275 0 0 1 .124-.124z"
                                    fill="currentColor"></path></svg></span>
                        <div class="business-reactions-view__counter">1</div>
                    </div>
                </div>
                <div class="business-review-view__share-control" aria-hidden="false" aria-label="Поделиться"
                     role="button" tabindex="0"><span tag="span" style="font-size: 0px; line-height: 0;"
                                                      class="inline-image _loaded icon" aria-hidden="true"><svg
                            width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path
                                d="M11 4.5a.5.5 0 0 0-.5-.5H8a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4v-2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5V16a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2.5a.5.5 0 0 0 .5-.5v-1z"
                                fill="currentColor"></path><path
                                d="M14.5 6h2.086l-5.293 5.293a1 1 0 0 0 1.414 1.414L18 7.414V9.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V5a1 1 0 0 0-1-1h-4.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5z"
                                fill="currentColor"></path></svg></span></div>
            </div>
            <div class="business-review-view__comment-expand" aria-hidden="false"
                 aria-label="Посмотреть ответ организации" role="button" aria-expanded="false" tabindex="0">Посмотреть
                ответ организации
            </div>
        </div>
    </div>
</div>
@endif

</body>
</html>
