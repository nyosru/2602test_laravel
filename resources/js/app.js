import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
// import { ZiggyVue } from '../../vendor/tightenco/ziggy';  // если используете Ziggy
// import { ZiggyVue } from 'ziggy-js/vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) =>
        // resolvePageComponent(
        //     `./Pages/${name}.vue`,
        //     import.meta.glob('./Pages/**/*.vue')
        // ),
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        ),

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            // .use(ZiggyVue, props.initialPage.props.ziggy)
            .use(ZiggyVue)  // раскомментируйте, если нужен Ziggy
            .mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});
