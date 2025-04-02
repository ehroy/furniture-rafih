import "./bootstrap";

import { createApp, h, onMounted } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createI18n } from "vue-i18n";
import helpers from "./helpers";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const savedLang = localStorage.getItem("lang") || "en";

        const i18n = createI18n({
            legacy: false,
            locale: savedLang,
            fallbackLocale: "en",
            messages: props.initialPage.props.translations,
        });
        createApp({
            render: () => h(App, props),
            provide: {
                helpers: helpers,
            },
            setup() {
                onMounted(() => {
                    document
                        .getElementById("app")
                        ?.removeAttribute("data-page");
                });
            },
        })
            .use(plugin)
            .use(i18n)
            .mount(el);
    },
});
