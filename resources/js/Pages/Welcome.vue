<script setup>
import {Head, Link} from '@inertiajs/vue3';
import ParsingYandex from "@/Pages/ParsingYandex.vue";
// import { route } from 'ziggy-js';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <div class="xcontainer min-h-[100vh] mx-auto">
        <div class="flex flex-row min-h-[100vh]">

            <div class="flex flex-col min-h-[100vh] w-[250px] p-3 bg-[#F6F8FA] ">
                <div class="p-3 ">
                    <a
                        class="flex-shrink-0"
                        href="#"><img alt="Daily Grow"
                        src="/yandex_company/logo.svg"
                    ></a>
                </div>

                <a href="#" class="rounded flex flex-row items-center  bg-white p-2 text-xl">

                    <span class="inline w-[24px] mr-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.71 15.58L17.19 11.07C17.2846 10.6094 17.3315 10.1402 17.33 9.67001C17.3296 8.38066 17.0042 7.1122 16.3839 5.98189C15.7636 4.85158 14.8683 3.89588 13.7809 3.20315C12.6934 2.51041 11.4489 2.10299 10.1623 2.01855C8.87572 1.9341 7.58862 2.17535 6.41995 2.72001C6.27189 2.78764 6.14258 2.8904 6.04324 3.01936C5.94391 3.14832 5.87756 3.29958 5.84995 3.46001C5.82246 3.61839 5.83355 3.78107 5.88229 3.93426C5.93103 4.08745 6.01599 4.22663 6.12995 4.34001L10.48 8.68001L8.67995 10.48L4.33995 6.13001C4.22562 6.01781 4.08601 5.93472 3.93287 5.88773C3.77972 5.84075 3.61754 5.83124 3.45995 5.86001C3.30053 5.8866 3.14994 5.95144 3.02106 6.04897C2.89218 6.1465 2.78886 6.27381 2.71995 6.42001C2.17348 7.59251 1.93243 8.88419 2.01924 10.1749C2.10606 11.4656 2.5179 12.7133 3.21647 13.8021C3.91503 14.8908 4.87762 15.7852 6.0147 16.4021C7.15177 17.0189 8.42638 17.3381 9.71995 17.33C10.1902 17.3315 10.6593 17.2846 11.12 17.19L15.63 21.71C15.7229 21.8037 15.8335 21.8781 15.9554 21.9289C16.0772 21.9797 16.2079 22.0058 16.34 22.0058C16.472 22.0058 16.6027 21.9797 16.7245 21.9289C16.8464 21.8781 16.957 21.8037 17.05 21.71C17.1437 21.617 17.2181 21.5064 17.2688 21.3846C17.3196 21.2627 17.3458 21.132 17.3458 21C17.3458 20.868 17.3196 20.7373 17.2688 20.6154C17.2181 20.4936 17.1437 20.383 17.05 20.29L12.15 15.39C12.0275 15.2684 11.8757 15.1805 11.7092 15.1349C11.5427 15.0894 11.3673 15.0877 11.2 15.13C10.7171 15.2593 10.2198 15.3265 9.71995 15.33C8.972 15.3366 8.23014 15.1951 7.53709 14.9138C6.84405 14.6324 6.21353 14.2167 5.68184 13.6906C5.15016 13.1645 4.72783 12.5384 4.43917 11.8484C4.15052 11.1583 4.00124 10.418 3.99995 9.67001C3.99866 9.33502 4.02542 9.00052 4.07995 8.67001L7.99995 12.6C8.09292 12.6937 8.20352 12.7681 8.32538 12.8189C8.44724 12.8697 8.57794 12.8958 8.70995 12.8958C8.84197 12.8958 8.97267 12.8697 9.09453 12.8189C9.21639 12.7681 9.32699 12.6937 9.41995 12.6L12.6 9.39001C12.7802 9.20354 12.8809 8.95434 12.8809 8.695C12.8809 8.43567 12.7802 8.18647 12.6 8.00001L8.70995 4.08001C9.04054 4.02602 9.37499 3.99926 9.70995 4.00001C11.212 4.00265 12.6516 4.6012 13.7128 5.66424C14.774 6.72729 15.37 8.16796 15.37 9.67001C15.3665 10.1698 15.2993 10.6672 15.17 11.15C15.1276 11.3173 15.1293 11.4928 15.1749 11.6592C15.2204 11.8257 15.3083 11.9776 15.43 12.1L20.33 17C20.5183 17.1883 20.7737 17.2941 21.04 17.2941C21.3063 17.2941 21.5616 17.1883 21.75 17C21.9383 16.8117 22.044 16.5563 22.044 16.29C22.044 16.0237 21.9383 15.7683 21.75 15.58H21.71Z"
                            fill="#DCE4EA"/>
                    </svg>
                        </span>

                    Отзывы</a>
                <a href="#" class="rounded bg-white/50 p-2 text-sm
flex flex-row items-center
">
                    <span class="w-[24px] mr-2">&nbsp;</span>
                    Отзывы</a>
                <a href="#" class="rounded bg-white/50
                flex flex-row items-center
                p-2 text-sm">
                    <span class="w-[24px] mr-2">&nbsp;</span>
                    Настройка</a>
            </div>

            <div class="flex-1 min-h-[100vh]">

                <header class="bg-white h-auto w-full flex items-right ">

                    <nav
                        xv-if="canLogin"
                        class="p-3  flex flex-1 justify-end
border-b-2 border-gray-100
">
<!--                        <Link-->
<!--                            v-if="$page.props.auth.user"-->
<!--                            :href="route('dashboard')"-->
<!--                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"-->
<!--                        >-->
<!--                            Dashboard-->
<!--                        </Link>-->


<!--                            <Link-->
<!--                                :href="route('login')"-->
<!--                                class="-->
<!--                            rounded-md-->
<!--                            px-3 py-2 text-black-->

<!--"-->
<!--                            >-->
<!--                                Log in-->
<!--                            </Link>-->

<!--                            <Link-->
<!--                                v-if="canRegister"-->
<!--                                :href="route('register')"-->
<!--                                class="-->
<!--                                px-3 py-2 text-black-->
<!--                                 "-->
<!--                            >-->
<!--                                Register-->
<!--                            </Link>-->

                    </nav>

                </header>


                <!--    <main class="bg-background flex-1">-->
                <header
                    v-if="1==2"
                    class="
        bg-white md:h-desktop_header h-auto flex items-center px-4 app-header
        w-full text-right

">
                    <div class="header flex flex-row justify-between">
                        <div
                            class="flex flex-row md:justify-end justify-around items-center w-full md:flex-nowrap flex-wrap">
                            <a
                                class="flex-shrink-0" href="https://app.daily-grow.com/c"><img alt="Daily Grow"
                                                                                               src="/yandex_company/logo.svg"
                                                                                               class="mr-12"></a>
                            <div class="flex items-center w-full"><a class="mr-4 flex-shrink-0"
                                                                     href="https://app.daily-grow.com/c"><img
                                alt="projects-list" src="/icons/research.svg"></a>
                                <div data-v-e343acf6="" class="w-full md:w-80">
                                    <div data-v-e343acf6="" class="searchable-select"><input data-v-e343acf6=""
                                                                                             type="text"
                                                                                             class="select-control searchable-select__size-input"><input
                                        data-v-e343acf6="" type="text"
                                        class="select-control searchable-select__searchInput"
                                        data-focused="false" data-muted="true" placeholder="Выбрать проект" value="">
                                        <div data-v-e343acf6="" class="searchable-select__fake-input select-control"
                                             data-muted="true"><!----><span data-v-e343acf6=""
                                                                            class="text-gray-dark text-opacity-40">Выбрать проект</span>
                                        </div>
                                        <div data-v-e343acf6="" class="searchable-select__options max-h-48"
                                             style="display: none;">
                                            <ul data-v-e343acf6="">
                                                <li data-v-e343acf6="" title="Список проектов" data-selected="false">
                                                    <div data-v-e343acf6="" class="py-2"><a
                                                        class="control campaign flex items-center pr-2 w-full">
                                                        <div class="flex-grow text-ellipsis overflow-hidden">Список
                                                            проектов
                                                        </div>
                                                        <div
                                                            class="flex flex-row flex-wrap justify-items-center items-center h-6 flex-shrink-0"></div>
                                                    </a></div>
                                                </li>
                                                <li data-v-e343acf6="" title="Новый проект" data-selected="false">
                                                    <div data-v-e343acf6="" class="py-2"><a
                                                        class="control campaign flex items-center pr-2 w-full">
                                                        <div class="flex-grow text-ellipsis overflow-hidden">Новый
                                                            проект
                                                        </div>
                                                        <div
                                                            class="flex flex-row flex-wrap justify-items-center items-center h-6 flex-shrink-0"></div>
                                                    </a></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow md:block hidden"></div>
                            <div
                                class="flex-shrink-0 grid grid-cols-2 gap-x-2 gap-y-0 md:grid-cols-1 px-2 md:py-0 py-4 md:text-left text-center text-gray-500 md:text-xs text-sm md:w-auto w-full">
                                <p>Сергей</p><a
                                href="https://app.daily-grow.com/c/4813/payment"><span>Баланс:&nbsp;</span><span>0&nbsp;₽</span></a>
                            </div>
                            <a href="https://t.me/dailygrow_bot" target="_blank" class="w-10 flex-shrink-0"><img
                                src="/icons/support.svg" alt="tg"></a><a
                            href="https://imtera.notion.site/imtera/DailyGrow-39af267e229f4371bc3585ad79ced900"
                            class="w-5 mx-2.5 flex-shrink-0"><img src="/icons/circle-question-regular.svg"
                                                                  alt="help"></a>
                            <div class="relative flex-shrink-0">
                                <div></div>
                                <div class="fixed inset-0 z-40" style="display: none;"></div>
                                <div class="absolute z-50 mt-2 rounded-md shadow-lg 48 origin-top-right right-0"
                                     style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white"></div>
                                </div>
                            </div>
                            <div class="relative flex-shrink-0">
                                <div><a class="control cursor-pointer"><img src="/icons/notifications.svg"
                                                                            alt="notifications"
                                                                            class="w-10"></a></div>
                                <div class="fixed inset-0 z-40" style="display: none;"></div>
                                <div
                                    class="absolute z-50 mt-2 rounded-md shadow-lg w-notifications-dropdown origin-top-right right-0"
                                    style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                                        <div class="p-3 w-full">
                                            <div class="notifs-scroll-container">
                                                <div>
                                                    <div
                                                        class="px-4 text-xs leading-5 flex-shrink-0 mr-5 text-error text-opacity-80">
                                                        Вы ещё не получали уведомления
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex-shrink-0">
                                <div><a class="control cursor-pointer"><img src="/icons/cog.svg" alt="cog" class="w-10"></a>
                                </div>
                                <div class="fixed inset-0 z-40" style="display: none;"></div>
                                <div class="absolute z-50 mt-2 rounded-md shadow-lg 48 origin-top-right right-0"
                                     style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                                        <div class="grid grid-cols-1 cog-dropdown w-40"><a
                                            href="https://app.daily-grow.com/user/change-pass">Смена пароля</a><a
                                            href="https://app.daily-grow.com/c/settings">Настройка проектов</a><a
                                            href="https://app.daily-grow.com/c/4813/payment">Оплата и баланс</a><a
                                            href="https://app.daily-grow.com/user/settings-notifications">Уведомления</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="flex-shrink-0" type="button"><img src="/icons/logout.svg" alt="logout"
                                                                             class="w-10">
                            </button>
                        </div>
                    </div>
                </header>

                <div class="px-8 py-4">
                    <parsing-yandex />
                </div>


                <div v-if="1==2" class="md:py-10 md:px-9 py-6 px-6"><!---->
                    <div class="mt-6 flex md:flex-row flex-col justify-start items-start">
                        <div class="period-controls">
                            <div class="fixed inset-0 z-40" style="display: none;"></div>
                            <div class="relative period-controls-dropdown-container">
                                <div>
                                    <div class="relative inline-block">
                                        <div>
                                            <button class="period-dropdown min-w-[12rem] text-left" type="button">9 - 15
                                                февр.
                                                2026
                                            </button>
                                        </div>
                                        <div class="fixed inset-0 z-40" style="display: none;"></div>
                                        <div class="absolute z-50 mt-2 rounded-md shadow-lg 48 origin-top-right right-0"
                                             style="display: none;">
                                            <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                                                <div class="dropdown"><a>Вчера</a><a>Прошлая неделя</a><a>7
                                                    дней</a><a>Месяц</a><a>Прошлый
                                                    месяц</a><a>Этот год</a><a>Указать период</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!---->
                                <div class="absolute z-50 mt-2 rounded-md shadow-lg 260 origin-top-left left-0"
                                     style="display: none;">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                                        <div class="p-2">
                                            <div
                                                data-helptext="Press the arrow keys to navigate by day, Home and End to navigate to week ends, PageUp and PageDown to navigate by month, Alt+PageUp and Alt+PageDown to navigate by year"
                                                class="vc-container vc-monthly vc-blue vc-light vc-bordered">
                                                <div class="vc-pane-container">
                                                    <div class="vc-pane-header-wrapper">
                                                        <div class="vc-header is-lg"
                                                             style="grid-template-columns: [prev] auto 1fr [title] auto 1fr [next] auto;">
                                                            <button type="button" class="vc-arrow vc-prev vc-focus">
                                                                <svg stroke-linecap="round" stroke-linejoin="round"
                                                                     viewBox="0 0 24 24" width="24" height="24"
                                                                     class="vc-base-icon">
                                                                    <polyline points="15 18 9 12 15 6"></polyline>
                                                                </svg>
                                                            </button><!---->
                                                            <button type="button" class="vc-arrow vc-next vc-focus"
                                                                    disabled="">
                                                                <svg stroke-linecap="round" stroke-linejoin="round"
                                                                     viewBox="0 0 24 24" width="24" height="24"
                                                                     class="vc-base-icon">
                                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="vc-pane-layout"
                                                         style="grid-template-columns: repeat(1, 1fr);">
                                                        <div
                                                            class="vc-pane row-1 row-from-end-1 column-1 column-from-end-1">
                                                            <div class="vc-header is-lg"
                                                                 style="grid-template-columns: [prev] auto 1fr [title] auto 1fr [next] auto;">
                                                                <!---->
                                                                <div class="vc-title-wrapper">
                                                                    <button type="button" class="vc-title">
                                                                        <span>февраль 2026</span></button>
                                                                </div><!----></div>
                                                            <div class="vc-weeks">
                                                                <div class="vc-weekdays">
                                                                    <div class="vc-weekday vc-weekday-2">П</div>
                                                                    <div class="vc-weekday vc-weekday-3">В</div>
                                                                    <div class="vc-weekday vc-weekday-4">С</div>
                                                                    <div class="vc-weekday vc-weekday-5">Ч</div>
                                                                    <div class="vc-weekday vc-weekday-6">П</div>
                                                                    <div class="vc-weekday vc-weekday-7">С</div>
                                                                    <div class="vc-weekday vc-weekday-1">В</div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-01-26 day-26 day-from-end-6 weekday-2 weekday-position-1 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-prev-month on-top on-left vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="понедельник, 26 янв. 2026 г."
                                                                            aria-disabled="false" role="button">26
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-01-27 day-27 day-from-end-5 weekday-3 weekday-position-2 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-prev-month on-top vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 27 янв. 2026 г."
                                                                            aria-disabled="false" role="button">27
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-01-28 day-28 day-from-end-4 weekday-4 weekday-position-3 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-prev-month on-top vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 28 янв. 2026 г."
                                                                            aria-disabled="false" role="button">28
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-01-29 day-29 day-from-end-3 weekday-5 weekday-position-4 weekday-ordinal-5 weekday-ordinal-from-end-0 week-5 week-from-end-1 in-prev-month on-top vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 29 янв. 2026 г."
                                                                            aria-disabled="false" role="button">29
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-01-30 day-30 day-from-end-2 weekday-6 weekday-position-5 weekday-ordinal-5 weekday-ordinal-from-end-0 week-5 week-from-end-1 in-prev-month on-top vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 30 янв. 2026 г."
                                                                            aria-disabled="false" role="button">30
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-01-31 day-31 day-from-end-1 weekday-7 weekday-position-6 weekday-ordinal-5 weekday-ordinal-from-end-0 week-5 week-from-end-1 in-prev-month on-top vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 31 янв. 2026 г."
                                                                            aria-disabled="false" role="button">31
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-01 day-1 day-from-end-28 weekday-1 weekday-position-7 weekday-ordinal-1 weekday-ordinal-from-end-4 week-1 week-from-end-5 is-first-day in-month on-top on-right vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 1 февр. 2026 г."
                                                                            aria-disabled="false" role="button">1
                                                                        </div><!----><!----></div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-02-02 day-2 day-from-end-27 weekday-2 weekday-position-1 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month on-left vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="понедельник, 2 февр. 2026 г."
                                                                            aria-disabled="false" role="button">2
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-03 day-3 day-from-end-26 weekday-3 weekday-position-2 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 3 февр. 2026 г."
                                                                            aria-disabled="false" role="button">3
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-04 day-4 day-from-end-25 weekday-4 weekday-position-3 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 4 февр. 2026 г."
                                                                            aria-disabled="false" role="button">4
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-05 day-5 day-from-end-24 weekday-5 weekday-position-4 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 5 февр. 2026 г."
                                                                            aria-disabled="false" role="button">5
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-06 day-6 day-from-end-23 weekday-6 weekday-position-5 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 6 февр. 2026 г."
                                                                            aria-disabled="false" role="button">6
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-07 day-7 day-from-end-22 weekday-7 weekday-position-6 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-4 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 7 февр. 2026 г."
                                                                            aria-disabled="false" role="button">7
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-08 day-8 day-from-end-21 weekday-1 weekday-position-7 weekday-ordinal-2 weekday-ordinal-from-end-3 week-2 week-from-end-4 in-month on-right vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 8 февр. 2026 г."
                                                                            aria-disabled="false" role="button">8
                                                                        </div><!----><!----></div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-02-09 day-9 day-from-end-20 weekday-2 weekday-position-1 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month on-left vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="понедельник, 9 февр. 2026 г."
                                                                            aria-disabled="false" role="button">9
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-10 day-10 day-from-end-19 weekday-3 weekday-position-2 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 10 февр. 2026 г."
                                                                            aria-disabled="false" role="button">10
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-11 day-11 day-from-end-18 weekday-4 weekday-position-3 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 11 февр. 2026 г."
                                                                            aria-disabled="false" role="button">11
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-12 day-12 day-from-end-17 weekday-5 weekday-position-4 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 12 февр. 2026 г."
                                                                            aria-disabled="false" role="button">12
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-13 day-13 day-from-end-16 weekday-6 weekday-position-5 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 13 февр. 2026 г."
                                                                            aria-disabled="false" role="button">13
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-14 day-14 day-from-end-15 weekday-7 weekday-position-6 weekday-ordinal-2 weekday-ordinal-from-end-3 week-3 week-from-end-3 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 14 февр. 2026 г."
                                                                            aria-disabled="false" role="button">14
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-15 day-15 day-from-end-14 weekday-1 weekday-position-7 weekday-ordinal-3 weekday-ordinal-from-end-2 week-3 week-from-end-3 in-month on-right vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 15 февр. 2026 г."
                                                                            aria-disabled="false" role="button">15
                                                                        </div><!----><!----></div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-02-16 day-16 day-from-end-13 weekday-2 weekday-position-1 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 is-today in-month on-left vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr"
                                                                            tabindex="0"
                                                                            aria-label="понедельник, 16 февр. 2026 г."
                                                                            aria-disabled="false" role="button">16
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-17 day-17 day-from-end-12 weekday-3 weekday-position-2 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 17 февр. 2026 г."
                                                                            aria-disabled="true" role="button">17
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-18 day-18 day-from-end-11 weekday-4 weekday-position-3 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 18 февр. 2026 г."
                                                                            aria-disabled="true" role="button">18
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-19 day-19 day-from-end-10 weekday-5 weekday-position-4 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 19 февр. 2026 г."
                                                                            aria-disabled="true" role="button">19
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-20 day-20 day-from-end-9 weekday-6 weekday-position-5 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 20 февр. 2026 г."
                                                                            aria-disabled="true" role="button">20
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-21 day-21 day-from-end-8 weekday-7 weekday-position-6 weekday-ordinal-3 weekday-ordinal-from-end-2 week-4 week-from-end-2 in-month vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 21 февр. 2026 г."
                                                                            aria-disabled="true" role="button">21
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-22 day-22 day-from-end-7 weekday-1 weekday-position-7 weekday-ordinal-4 weekday-ordinal-from-end-1 week-4 week-from-end-2 in-month on-right vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 22 февр. 2026 г."
                                                                            aria-disabled="true" role="button">22
                                                                        </div><!----><!----></div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-02-23 day-23 day-from-end-6 weekday-2 weekday-position-1 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-month on-bottom on-left vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="понедельник, 23 февр. 2026 г."
                                                                            aria-disabled="true" role="button">23
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-24 day-24 day-from-end-5 weekday-3 weekday-position-2 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-month on-bottom vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 24 февр. 2026 г."
                                                                            aria-disabled="true" role="button">24
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-25 day-25 day-from-end-4 weekday-4 weekday-position-3 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-month on-bottom vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 25 февр. 2026 г."
                                                                            aria-disabled="true" role="button">25
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-26 day-26 day-from-end-3 weekday-5 weekday-position-4 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-month on-bottom vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 26 февр. 2026 г."
                                                                            aria-disabled="true" role="button">26
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-27 day-27 day-from-end-2 weekday-6 weekday-position-5 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 in-month on-bottom vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 27 февр. 2026 г."
                                                                            aria-disabled="true" role="button">27
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-02-28 day-28 day-from-end-1 weekday-7 weekday-position-6 weekday-ordinal-4 weekday-ordinal-from-end-1 week-5 week-from-end-1 is-last-day in-month on-bottom vc-day-box-center-center">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 28 февр. 2026 г."
                                                                            aria-disabled="true" role="button">28
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-01 day-1 day-from-end-28 weekday-1 weekday-position-7 weekday-ordinal-1 weekday-ordinal-from-end-4 week-1 week-from-end-6 in-next-month on-bottom on-right vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 1 мар. 2026 г."
                                                                            aria-disabled="true" role="button">1
                                                                        </div><!----><!----></div>
                                                                </div>
                                                                <div class="vc-week"><!---->
                                                                    <div
                                                                        class="vc-day id-2026-03-02 day-2 day-from-end-27 weekday-2 weekday-position-1 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month on-left vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="понедельник, 2 мар. 2026 г."
                                                                            aria-disabled="true" role="button">2
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-03 day-3 day-from-end-26 weekday-3 weekday-position-2 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="вторник, 3 мар. 2026 г."
                                                                            aria-disabled="true" role="button">3
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-04 day-4 day-from-end-25 weekday-4 weekday-position-3 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="среда, 4 мар. 2026 г."
                                                                            aria-disabled="true" role="button">4
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-05 day-5 day-from-end-24 weekday-5 weekday-position-4 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="четверг, 5 мар. 2026 г."
                                                                            aria-disabled="true" role="button">5
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-06 day-6 day-from-end-23 weekday-6 weekday-position-5 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="пятница, 6 мар. 2026 г."
                                                                            aria-disabled="true" role="button">6
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-07 day-7 day-from-end-22 weekday-7 weekday-position-6 weekday-ordinal-1 weekday-ordinal-from-end-4 week-2 week-from-end-5 in-next-month vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="суббота, 7 мар. 2026 г."
                                                                            aria-disabled="true" role="button">7
                                                                        </div><!----><!----></div>
                                                                    <div
                                                                        class="vc-day id-2026-03-08 day-8 day-from-end-21 weekday-1 weekday-position-7 weekday-ordinal-2 weekday-ordinal-from-end-3 week-2 week-from-end-5 in-next-month on-right vc-day-box-center-center is-not-in-month">
                                                                        <!---->
                                                                        <div
                                                                            class="vc-day-content vc-focusable vc-focus vc-attr vc-disabled"
                                                                            tabindex="-1"
                                                                            aria-label="воскресенье, 8 мар. 2026 г."
                                                                            aria-disabled="true" role="button">8
                                                                        </div><!----><!----></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!----></div>
                                            </div>
                                            <div class="vc-popover-content-wrapper is-interactive"><!----></div>
                                            <div class="vc-popover-content-wrapper is-interactive"><!----></div>
                                            <button class="btn btn-primary btn-block btn-md mt-2" disabled=""
                                                    type="button">
                                                Выбрать
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="period-control period-button" type="button">Сегодня</button>
                            <button class="period-control period-button" type="button">Вчера</button>
                            <button class="period-control period-button" type="button">7 дней</button>
                            <button class="period-control period-button" type="button">30 дней</button>
                            <button class="period-control period-button" type="button">Месяц</button>
                            <button class="period-control period-button" type="button">90 дней</button>
                        </div>
                        <div class="flex-grow md:block hidden"></div>
                        <a class="btn btn-md btn-outline-base flex-shrink-0 md:mt-0 mt-2 md-w-auto-full"
                           href="https://app.daily-grow.com/c/create">Создать проект</a></div>
                    <div class="mt-6 flex flew-row justify-start items-center"><input
                        class="max-w-xs py-2 px-4 inline form-control" type="text" placeholder="ID или название проекта"
                        value="">
                        <div style="display: none;"><p class="text-error text-sm w-full"></p></div>
                        <img alt="compare" src="/icons/colum.jpeg" class="cursor-pointer inline ml-2 w-6"></div>
                    <div class="relative overflow-x-auto w-full mt-6"><!---->
                        <table class="projects-list min-w-full">
                            <thead>
                            <tr style="user-select: none;">
                                <th class="projects-list__th-item"> Название</th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>Расходы<img src="/icons/arrow_down.svg" alt="desc" class="inline"></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>Заявки<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>Клики<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>CPC<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>CR<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>CPL<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>Продажи<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>Доход<!----></nobr>
                                    </div>
                                </th>
                                <th colspan="1" class="projects-list__th-item">
                                    <div class="cursor-pointer projects-list__th-item projects-list__th-item_clickable">
                                        <nobr>ДРР<!----></nobr>
                                    </div>
                                </th>
                                <th class="projects-list__th-item"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="flex flex-row justify-start items-center flex-nowrap whitespace-nowrap w-full"><span
                                    class="inline cursor-pointer mr-1 flex-shrink-0 opacity-0 cursor-default"><img
                                    src="/icons/slider-deploy-down.svg" alt="-" class="inline"></span><a
                                    href="https://app.daily-grow.com/c/4813" class="font-bold cursor-pointer flex-grow"
                                    target="_blank">Новый проект</a>
                                    <div class="flex-shrink-0 flex flex-row flex-nowrap"></div>
                                </td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="projects-list__th-item"><span>-</span></td>
                                <td class="flex flew-row flex-nowrap items-center justify-center"><a
                                    class="flex-shrink-0"
                                    href="https://app.daily-grow.com/c/4813/source"><img
                                    alt="settings" src="/icons/cog-small.svg" class="w-6 p-1"></a><a
                                    class="flex-shrink-0"
                                    href="https://app.daily-grow.com/c/4813/edit"><img
                                    alt="settings" src="/icons/edit.svg" class="w-6 p-1"></a><a class="flex-shrink-0"
                                                                                                href="https://app.daily-grow.com/c/4813/delete"><img
                                    alt="settings" src="/icons/delete.svg" class="w-5 p-1"></a></td>
                            </tr>
                            <tr style="display: none;">
                                <td colspan="9999" class="py-2 ml-4">Пусто.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--    </main>-->
            </div>
        </div>
    </div>

    <div v-if="1==2">
        <Head title="Welcome"/>
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <img
                id="background"
                class="absolute -left-20 top-0 max-w-[877px]"
                src="https://laravel.com/assets/img/welcome/background.svg"
            />
            <div
                class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
            >
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header
                        class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                    >
                        <div class="flex lg:col-start-2 lg:justify-center">
                            <svg
                                class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]"
                                viewBox="0 0 62 65"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </div>
                        <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Log in
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </Link>
                            </template>
                        </nav>
                    </header>

                    <main class="mt-6">

                        <div class="flex flex-wrap items-center justify-center min-h-[70vh] ">
                            <div class="w-1/3">
                                <div class="border border-2 border-green-200 m-3 p-2
                            min-h-[100px]">1111
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="border border-2 border-green-200 m-3 p-2
                            min-h-[100px]">1111
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="border border-2 border-green-200 m-3 p-2
                            min-h-[100px]">1111
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="border border-2 border-green-200 m-3 p-2
                            min-h-[100px]">1111
                                </div>
                            </div>

                            <div class="w-1/3">
                                <div class="border border-2 border-green-200 m-3 p-2
                            min-h-[100px]">1111
                                </div>
                            </div>

                        </div>

                        <div v-if="1==2" class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a
                                href="https://laravel.com/docs"
                                id="docs-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div
                                    id="screenshot-container"
                                    class="relative flex w-full flex-1 items-stretch"
                                >
                                    <img
                                        src="https://laravel.com/assets/img/welcome/docs-light.svg"
                                        alt="Laravel documentation screenshot"
                                        class="aspect-video h-full w-full flex-1 rounded-[10px] object-cover object-top drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)] dark:hidden"
                                        @error="handleImageError"
                                    />
                                    <img
                                        src="https://laravel.com/assets/img/welcome/docs-dark.svg"
                                        alt="Laravel documentation screenshot"
                                        class="hidden aspect-video h-full w-full flex-1 rounded-[10px] object-cover object-top drop-shadow-[0px_4px_34px_rgba(0,0,0,0.25)] dark:block"
                                    />
                                    <div
                                        class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900"
                                    ></div>
                                </div>

                                <div
                                    class="relative flex items-center gap-6 lg:items-end"
                                >
                                    <div
                                        id="docs-card-content"
                                        class="flex items-start gap-6 lg:flex-col"
                                    >
                                        <div
                                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"
                                        >
                                            <svg
                                                class="size-5 sm:size-6"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    fill="#FF2D20"
                                                    d="M23 4a1 1 0 0 0-1.447-.894L12.224 7.77a.5.5 0 0 1-.448 0L2.447 3.106A1 1 0 0 0 1 4v13.382a1.99 1.99 0 0 0 1.105 1.79l9.448 4.728c.14.065.293.1.447.1.154-.005.306-.04.447-.105l9.453-4.724a1.99 1.99 0 0 0 1.1-1.789V4ZM3 6.023a.25.25 0 0 1 .362-.223l7.5 3.75a.251.251 0 0 1 .138.223v11.2a.25.25 0 0 1-.362.224l-7.5-3.75a.25.25 0 0 1-.138-.22V6.023Zm18 11.2a.25.25 0 0 1-.138.224l-7.5 3.75a.249.249 0 0 1-.329-.099.249.249 0 0 1-.033-.12V9.772a.251.251 0 0 1 .138-.224l7.5-3.75a.25.25 0 0 1 .362.224v11.2Z"
                                                />
                                                <path
                                                    fill="#FF2D20"
                                                    d="m3.55 1.893 8 4.048a1.008 1.008 0 0 0 .9 0l8-4.048a1 1 0 0 0-.9-1.785l-7.322 3.706a.506.506 0 0 1-.452 0L4.454.108a1 1 0 0 0-.9 1.785H3.55Z"
                                                />
                                            </svg>
                                        </div>

                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2
                                                class="text-xl font-semibold text-black dark:text-white"
                                            >
                                                Documentation
                                            </h2>

                                            <p class="mt-4 text-sm/relaxed">
                                                Laravel has wonderful documentation
                                                covering every aspect of the
                                                framework. Whether you are a
                                                newcomer or have prior experience
                                                with Laravel, we recommend reading
                                                our documentation from beginning to
                                                end.
                                            </p>
                                        </div>
                                    </div>

                                    <svg
                                        class="size-6 shrink-0 stroke-[#FF2D20]"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                                        />
                                    </svg>
                                </div>
                            </a>

                            <a
                                href="https://laracasts.com"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div
                                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"
                                >
                                    <svg
                                        class="size-5 sm:size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="#FF2D20">
                                            <path
                                                d="M24 8.25a.5.5 0 0 0-.5-.5H.5a.5.5 0 0 0-.5.5v12a2.5 2.5 0 0 0 2.5 2.5h19a2.5 2.5 0 0 0 2.5-2.5v-12Zm-7.765 5.868a1.221 1.221 0 0 1 0 2.264l-6.626 2.776A1.153 1.153 0 0 1 8 18.123v-5.746a1.151 1.151 0 0 1 1.609-1.035l6.626 2.776ZM19.564 1.677a.25.25 0 0 0-.177-.427H15.6a.106.106 0 0 0-.072.03l-4.54 4.543a.25.25 0 0 0 .177.427h3.783c.027 0 .054-.01.073-.03l4.543-4.543ZM22.071 1.318a.047.047 0 0 0-.045.013l-4.492 4.492a.249.249 0 0 0 .038.385.25.25 0 0 0 .14.042h5.784a.5.5 0 0 0 .5-.5v-2a2.5 2.5 0 0 0-1.925-2.432ZM13.014 1.677a.25.25 0 0 0-.178-.427H9.101a.106.106 0 0 0-.073.03l-4.54 4.543a.25.25 0 0 0 .177.427H8.4a.106.106 0 0 0 .073-.03l4.54-4.543ZM6.513 1.677a.25.25 0 0 0-.177-.427H2.5A2.5 2.5 0 0 0 0 3.75v2a.5.5 0 0 0 .5.5h1.4a.106.106 0 0 0 .073-.03l4.54-4.543Z"
                                            />
                                        </g>
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2
                                        class="text-xl font-semibold text-black dark:text-white"
                                    >
                                        Laracasts
                                    </h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laracasts offers thousands of video
                                        tutorials on Laravel, PHP, and JavaScript
                                        development. Check them out, see for
                                        yourself, and massively level up your
                                        development skills in the process.
                                    </p>
                                </div>

                                <svg
                                    class="size-6 shrink-0 self-center stroke-[#FF2D20]"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                                    />
                                </svg>
                            </a>

                            <a
                                href="https://laravel-news.com"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div
                                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"
                                >
                                    <svg
                                        class="size-5 sm:size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="#FF2D20">
                                            <path
                                                d="M8.75 4.5H5.5c-.69 0-1.25.56-1.25 1.25v4.75c0 .69.56 1.25 1.25 1.25h3.25c.69 0 1.25-.56 1.25-1.25V5.75c0-.69-.56-1.25-1.25-1.25Z"
                                            />
                                            <path
                                                d="M24 10a3 3 0 0 0-3-3h-2V2.5a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2V20a3.5 3.5 0 0 0 3.5 3.5h17A3.5 3.5 0 0 0 24 20V10ZM3.5 21.5A1.5 1.5 0 0 1 2 20V3a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v17c0 .295.037.588.11.874a.5.5 0 0 1-.484.625L3.5 21.5ZM22 20a1.5 1.5 0 1 1-3 0V9.5a.5.5 0 0 1 .5-.5H21a1 1 0 0 1 1 1v10Z"
                                            />
                                            <path
                                                d="M12.751 6.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 7.3v-.5a.75.75 0 0 1 .751-.753ZM12.751 10.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 11.3v-.5a.75.75 0 0 1 .751-.753ZM4.751 14.047h10a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-10A.75.75 0 0 1 4 15.3v-.5a.75.75 0 0 1 .751-.753ZM4.75 18.047h7.5a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-7.5A.75.75 0 0 1 4 19.3v-.5a.75.75 0 0 1 .75-.753Z"
                                            />
                                        </g>
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2
                                        class="text-xl font-semibold text-black dark:text-white"
                                    >
                                        Laravel News
                                    </h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laravel News is a community driven portal
                                        and newsletter aggregating all of the latest
                                        and most important news in the Laravel
                                        ecosystem, including new package releases
                                        and tutorials.
                                    </p>
                                </div>

                                <svg
                                    class="size-6 shrink-0 self-center stroke-[#FF2D20]"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                                    />
                                </svg>
                            </a>

                            <div
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800"
                            >
                                <div
                                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"
                                >
                                    <svg
                                        class="size-5 sm:size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <g fill="#FF2D20">
                                            <path
                                                d="M16.597 12.635a.247.247 0 0 0-.08-.237 2.234 2.234 0 0 1-.769-1.68c.001-.195.03-.39.084-.578a.25.25 0 0 0-.09-.267 8.8 8.8 0 0 0-4.826-1.66.25.25 0 0 0-.268.181 2.5 2.5 0 0 1-2.4 1.824.045.045 0 0 0-.045.037 12.255 12.255 0 0 0-.093 3.86.251.251 0 0 0 .208.214c2.22.366 4.367 1.08 6.362 2.118a.252.252 0 0 0 .32-.079 10.09 10.09 0 0 0 1.597-3.733ZM13.616 17.968a.25.25 0 0 0-.063-.407A19.697 19.697 0 0 0 8.91 15.98a.25.25 0 0 0-.287.325c.151.455.334.898.548 1.328.437.827.981 1.594 1.619 2.28a.249.249 0 0 0 .32.044 29.13 29.13 0 0 0 2.506-1.99ZM6.303 14.105a.25.25 0 0 0 .265-.274 13.048 13.048 0 0 1 .205-4.045.062.062 0 0 0-.022-.07 2.5 2.5 0 0 1-.777-.982.25.25 0 0 0-.271-.149 11 11 0 0 0-5.6 2.815.255.255 0 0 0-.075.163c-.008.135-.02.27-.02.406.002.8.084 1.598.246 2.381a.25.25 0 0 0 .303.193 19.924 19.924 0 0 1 5.746-.438ZM9.228 20.914a.25.25 0 0 0 .1-.393 11.53 11.53 0 0 1-1.5-2.22 12.238 12.238 0 0 1-.91-2.465.248.248 0 0 0-.22-.187 18.876 18.876 0 0 0-5.69.33.249.249 0 0 0-.179.336c.838 2.142 2.272 4 4.132 5.353a.254.254 0 0 0 .15.048c1.41-.01 2.807-.282 4.117-.802ZM18.93 12.957l-.005-.008a.25.25 0 0 0-.268-.082 2.21 2.21 0 0 1-.41.081.25.25 0 0 0-.217.2c-.582 2.66-2.127 5.35-5.75 7.843a.248.248 0 0 0-.09.299.25.25 0 0 0 .065.091 28.703 28.703 0 0 0 2.662 2.12.246.246 0 0 0 .209.037c2.579-.701 4.85-2.242 6.456-4.378a.25.25 0 0 0 .048-.189 13.51 13.51 0 0 0-2.7-6.014ZM5.702 7.058a.254.254 0 0 0 .2-.165A2.488 2.488 0 0 1 7.98 5.245a.093.093 0 0 0 .078-.062 19.734 19.734 0 0 1 3.055-4.74.25.25 0 0 0-.21-.41 12.009 12.009 0 0 0-10.4 8.558.25.25 0 0 0 .373.281 12.912 12.912 0 0 1 4.826-1.814ZM10.773 22.052a.25.25 0 0 0-.28-.046c-.758.356-1.55.635-2.365.833a.25.25 0 0 0-.022.48c1.252.43 2.568.65 3.893.65.1 0 .2 0 .3-.008a.25.25 0 0 0 .147-.444c-.526-.424-1.1-.917-1.673-1.465ZM18.744 8.436a.249.249 0 0 0 .15.228 2.246 2.246 0 0 1 1.352 2.054c0 .337-.08.67-.23.972a.25.25 0 0 0 .042.28l.007.009a15.016 15.016 0 0 1 2.52 4.6.25.25 0 0 0 .37.132.25.25 0 0 0 .096-.114c.623-1.464.944-3.039.945-4.63a12.005 12.005 0 0 0-5.78-10.258.25.25 0 0 0-.373.274c.547 2.109.85 4.274.901 6.453ZM9.61 5.38a.25.25 0 0 0 .08.31c.34.24.616.561.8.935a.25.25 0 0 0 .3.127.631.631 0 0 1 .206-.034c2.054.078 4.036.772 5.69 1.991a.251.251 0 0 0 .267.024c.046-.024.093-.047.141-.067a.25.25 0 0 0 .151-.23A29.98 29.98 0 0 0 15.957.764a.25.25 0 0 0-.16-.164 11.924 11.924 0 0 0-2.21-.518.252.252 0 0 0-.215.076A22.456 22.456 0 0 0 9.61 5.38Z"
                                            />
                                        </g>
                                    </svg>
                                </div>

                                <div class="pt-3 sm:pt-5">
                                    <h2
                                        class="text-xl font-semibold text-black dark:text-white"
                                    >
                                        Vibrant Ecosystem
                                    </h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Laravel's robust library of first-party
                                        tools and libraries, such as
                                        <a
                                            href="https://forge.laravel.com"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white dark:focus-visible:ring-[#FF2D20]"
                                        >Forge</a
                                        >,
                                        <a
                                            href="https://vapor.laravel.com"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Vapor</a
                                        >,
                                        <a
                                            href="https://nova.laravel.com"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Nova</a
                                        >,
                                        <a
                                            href="https://envoyer.io"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Envoyer</a
                                        >, and
                                        <a
                                            href="https://herd.laravel.com"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Herd</a
                                        >
                                        help you take your projects to the next
                                        level. Pair them with powerful open source
                                        libraries like
                                        <a
                                            href="https://laravel.com/docs/billing"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Cashier</a
                                        >,
                                        <a
                                            href="https://laravel.com/docs/dusk"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Dusk</a
                                        >,
                                        <a
                                            href="https://laravel.com/docs/broadcasting"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Echo</a
                                        >,
                                        <a
                                            href="https://laravel.com/docs/horizon"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Horizon</a
                                        >,
                                        <a
                                            href="https://laravel.com/docs/sanctum"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Sanctum</a
                                        >,
                                        <a
                                            href="https://laravel.com/docs/telescope"
                                            class="rounded-sm underline hover:text-black focus:outline-none focus-visible:ring-1 focus-visible:ring-[#FF2D20] dark:hover:text-white"
                                        >Telescope</a
                                        >, and more.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </main>

                    <footer
                        class="py-16 text-center text-sm text-black dark:text-white/70"
                    >
                        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>
