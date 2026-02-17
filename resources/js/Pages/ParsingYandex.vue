<template>
    <div class="min-h-screen ">
        <div class="max-w-4xl ">

            <div v-if="!parsedData" class="">

                <form @submit.prevent="parseYandexUrl" class="space-y-2">

                <h1 class="text-xl font-bold text-gray-900 mb-6">
                    Парсер Яндекс страниц
                </h1>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Введите ссылку Яндекса
                        </label>
                        <div class="relative">
                            <input
                                v-model="form.url"
                                required
                                type="url"

                                placeholder="https://yandex.ru/..."
                                class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                            />
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">🔗</span>
                        </div>
                        <p v-if="urlError" class="mt-2 text-sm text-red-600">
                            {{ urlError }}
                        </p>
                    </div>
                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                    >
                        {{ loading ? 'Парсим, файв секанд плиз ...' : 'Парсить страницу' }}
                    </button>
                </form>
<br/>
<br/>
                <div class="bg-yellow-300 p-2 rounded mt-3">
                    Результат обработки кешируется на 30 минут (повторные запросы проходят на порядок быстрее)
                </div>


            </div>

            <!-- Результат парсинга -->
            <div v-else class="space-y-8">

                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Результат парсинга: {{ parsedUrl || 'Не найден' }}
                    </h2>
                    <button
                        @click="resetForm"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                    >
                        ← Новый парсинг
                    </button>
                </div>

                Называние компании: {{ parsedData.data.original.name || 'Не найден' }}
                <br/>

                Рейтинг: {{ parsedData.data.original.rating || 'Не найден' }}
                <br/>
                <br/>

                <h2 class="font-bold text-xl">Отзывы</h2>
                <div class="max-h-[400px] border-2 border-red-300 p-5 rounded w-full overflow-auto bg-gray-200">
<!--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">-->
                        <div v-for="(review, index) in parsedData.data.original.reviews"
                             class="bg-white shadow-xl rounded-xl p-6 mb-3"
                        >
                            <div class="space-y-2">
                                <div>{{ review.date || 'Не найден' }}</div>
                                <div class="float-right"><strong>Оценка:</strong> {{ review.rating || 'Не найдено' }}</div>
                                <div><strong>{{ review.author || '--' }}</strong></div>
                                <div>{{ review.text || 'Не найдено' }}</div>
                            </div>


                    </div>
                </div>


                <h2 class="font-bold text-xl">businesAspects</h2>
                <div class="max-h-[300px] border-2 border-red-300 p-3 w-full overflow-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="(item, index) in parsedData.data.original.businesAspects">
                            {{ item }}
                        </div>
                    </div>
                </div>


                <div v-if="1==2">
                    <div v-if="1==2" class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-white shadow-xl rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Основная информация</h3>
                            <div class="space-y-3">
                                <div><strong>Заголовок:</strong> {{ parsedData.title || 'Не найден' }}</div>
                                <div><strong>Описание:</strong> {{ parsedData.description || 'Не найдено' }}</div>
                                <div><strong>Язык:</strong> {{ parsedData.lang || 'Не определён' }}</div>
                            </div>
                        </div>

                        <!-- Мета информация -->
                        <div class="bg-white shadow-xl rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Мета данные</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><strong>Хост:</strong> {{ parsedData.host }}</div>
                                <div><strong>Путь:</strong> {{ parsedData.path }}</div>
                                <div><strong>Кодировка:</strong> {{ parsedData.charset || 'Не найдена' }}</div>
                                <div><strong>Тип контента:</strong> {{ parsedData.contentType }}</div>
                            </div>
                        </div>
                    </div>
                    <div v-if="parsedData.openGraph"
                         class="bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-2xl rounded-xl p-8">
                        <h3 class="text-xl font-bold mb-6">Open Graph данные</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="(value, key) in parsedData.openGraph" :key="key"
                                 class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                                <div class="font-medium">{{ key.replace('og:', '') }}</div>
                                <div class="text-sm mt-1 truncate">{{ value }}</div>
                            </div>
                        </div>
                    </div>
                    <div v-if="1==2" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white shadow-xl rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Найденные ссылки
                                ({{ parsedData.links?.length || 0 }})</h3>
                            <div v-if="parsedData.links?.length" class="max-h-64 overflow-y-auto space-y-2">
                                <a
                                    v-for="(link, index) in parsedData.links.slice(0, 10)"
                                    :key="index"
                                    :href="link"
                                    target="_blank"
                                    class="block p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded text-sm truncate"
                                >
                                    {{ link }}
                                </a>
                            </div>
                            <p v-else class="text-gray-500 text-sm">Ссылки не найдены</p>
                        </div>

                        <div class="bg-white shadow-xl rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Изображения
                                ({{ parsedData.images?.length || 0 }})</h3>
                            <div v-if="parsedData.images?.length"
                                 class="grid grid-cols-3 gap-2 max-h-64 overflow-y-auto">
                                <img
                                    v-for="(img, index) in parsedData.images.slice(0, 9)"
                                    :key="index"
                                    :src="img"
                                    :alt="`Изображение ${index + 1}`"
                                    class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                    @click="openImage(img)"
                                />
                            </div>
                            <p v-else class="text-gray-500 text-sm">Изображения не найдены</p>
                        </div>
                    </div>
                </div>


                <h2 class="font-bold px-3 text-xl">Данные</h2>

                <div style="border:2px solid red; padding: 10px;"
                     class="max-h-[300px] border-2 border-green-300 p-3 w-full overflow-auto"
                >
                    <!--                    {{ parsedData }}-->
                    <pre>
                        {{ JSON.stringify(parsedData || 'Не найден', null, 2) }}
                    </pre>
                </div>


            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from 'vue'
import {useForm} from '@inertiajs/vue3'
import axios from 'axios'

const form = useForm({
    url: 'https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/',
})

const urlError = ref('')
const loading = ref(false)
const parsedData = ref(null)
const parsedUrl = ref('')

// const parseYandexUrl = () => {
// const parseYandexUrl = async () => {
//
//     if (!form.url.includes('yandex.ru') && !form.url.includes('yandex.com')) {
//         urlError.value = 'Только ссылки с Яндекса!'
//         return
//     }
//
//     loading.value = true
//     urlError.value = ''
//
//     // form.post('/parse-yandex', {
//     //     onSuccess: (page) => {
//     //         parsedData.value = page.props.parsedData
//     //         parsedUrl.value = page.props.parsedUrl
//     //         form.reset('url')
//     //     },
//     //     onError: (errors) => {
//     //         urlError.value = errors.url || 'Ошибка парсинга'
//     //     },
//     //     onFinish: () => {
//     //         loading.value = false
//     //     }
//     // })
//
//     try {
//         // await router.post('/api/parse-yandex', {url: urlInput.value}, {
//         await router.get('/api/parse-yandex', {url: urlInput.value}, {
//             preserveState: true,
//             preserveScroll: true,
//             onSuccess: (page) => {
//                 parsedData.value = page.props.parsedData
//                 // parsedUrl тоже можно передать как prop
//             },
//             onError: (errors) => {
//                 urlError.value = 'Ошибка: ' + (errors.message || JSON.stringify(errors))
//             }
//         })
//     } catch (error) {
//         urlError.value = 'Сетевая ошибка: ' + error.message
//     } finally {
//         loading.value = false
//     }


//
// const parseYandexUrl = () => {
//     form.get('/api/parse-yandex', {
//         preserveState: true,
//         preserveScroll: true,
//         onSuccess: (page) => {
//             parsedData.value = page.props.parsedData
//             parsedUrl.value = form.url
//         },
//         onError: (errors) => {
//             urlError.value = errors.url || 'Ошибка парсинга'
//         },
//         onFinish: () => loading.value = false,
//     })
// }


const parseYandexUrl = async () => {
    if (!form.url.includes('yandex.ru') && !form.url.includes('yandex.com')) {
        urlError.value = 'Только ссылки с Яндекса!'
        return
    }

    loading.value = true
    urlError.value = ''

    try {
        const response = await axios.get('/api/parse-yandex', {
            params: {url: form.url}
        })

        parsedData.value = response.data
        parsedUrl.value = form.url
        form.reset('url')
    } catch (error) {
        if (error.response) {
            urlError.value = 'Ошибка1: ' + error.response.data.message || 'Неизвестная ошибка'
        } else if (error.request) {
            urlError.value = 'Нет ответа от сервера'
        } else {
            urlError.value = 'Ошибка2: ' + error.message
        }
    } finally {
        loading.value = false
    }
}

// }

const resetForm = () => {
    parsedData.value = null
    parsedUrl.value = ''
    form.reset()
}
</script>
