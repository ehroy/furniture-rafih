<template>
    <div class="fixed right-4 z-50 bottom-20">
        <a
            :href="helpers.WaButton(Global, '/')"
            target="_blank"
            class="flex items-center justify-center w-14 h-14 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transition"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                class="w-8 h-8"
                viewBox="0 0 16 16"
            >
                <path
                    d="M13.601 2.383A7.903 7.903 0 008 0C3.581 0 0 3.582 0 8a7.91 7.91 0 001.174 4.15L.08 15.32a.655.655 0 00.771.774l3.235-1.104A7.91 7.91 0 008 16c4.419 0 8-3.582 8-8a7.902 7.902 0 00-2.399-5.617zM8 14.5a6.461 6.461 0 01-3.333-.903.637.637 0 00-.485-.069l-2.307.788 1.12-2.402a.636.636 0 00-.066-.626A6.505 6.505 0 011.5 8c0-3.593 2.907-6.5 6.5-6.5 3.592 0 6.5 2.907 6.5 6.5 0 3.592-2.908 6.5-6.5 6.5zm3.158-4.949c-.172-.087-1.017-.501-1.175-.557s-.272-.087-.387.087-.442.558-.542.674c-.099.115-.199.131-.37.044A5.282 5.282 0 016.99 8.65c-.542-.542-.722-.975-.81-1.138-.087-.164-.009-.253.065-.337.067-.074.15-.199.224-.298.075-.099.099-.164.15-.273.05-.11.025-.205-.012-.298-.037-.093-.386-.927-.529-1.269-.14-.342-.283-.296-.387-.302-.099-.006-.212-.008-.325-.008a.626.626 0 00-.448.212c-.148.165-.57.558-.57 1.364 0 .806.583 1.587.664 1.698.081.11 1.15 1.77 2.788 2.49 1.638.72 1.638.48 1.935.448.297-.031.96-.391 1.096-.77.136-.38.136-.706.099-.773s-.16-.123-.332-.21z"
                />
            </svg>
        </a>
    </div>
    <transition
        enter-active-class="transition-opacity duration-500"
        enter-from-class="opacity-0 translate-y-5"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition-opacity duration-500"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-5"
    >
        <div
            v-if="
                showOrderPopup &&
                randomProduct &&
                randomProduct.image &&
                randomProduct.name
            "
            class="fixed bottom-5 left-5 bg-white border border-gray-300 p-2 shadow-lg rounded-lg flex items-center gap-3 px-10 mb-16"
        >
            <img
                class="w-12 h-12 object-cover rounded-sm"
                :src="helpers.imageUrl(randomProduct.image)"
                :alt="randomProduct.name"
            />
            <div>
                <p class="text-sm font-bold">
                    {{ randomProduct.name }}
                </p>
                <p class="text-xs text-gray-500">Baru saja dibeli!</p>
            </div>
        </div>
    </transition>
</template>
<script setup>
import { inject, onMounted, ref } from "vue";

const props = defineProps({
    Global: Object,
    Products: Array, // Perbaikan tipe data
});

const helpers = inject("helpers");
const showOrderPopup = ref(false);
const randomProduct = ref({});

const startOrderPopup = () => {
    const showRandomPopup = () => {
        const data = props.Products || [];
        if (data.length === 0) return; // Pastikan produk ada

        const lastPopupTime = localStorage.getItem("lastPopupTime");
        const now = Date.now();
        const minWaitTime = 1 * 60 * 60 * 1000; // 1 jam
        const maxWaitTime = 12 * 60 * 60 * 1000; // 12 jam

        if (!lastPopupTime || now - lastPopupTime > minWaitTime) {
            const randomIndex = Math.floor(Math.random() * data.length);
            randomProduct.value = data[randomIndex];
            showOrderPopup.value = true;

            setTimeout(() => {
                showOrderPopup.value = false;
            }, 3000);

            localStorage.setItem("lastPopupTime", now);
        }

        const randomTime = Math.floor(
            Math.random() * (maxWaitTime - minWaitTime) + minWaitTime
        );

        if (data.length > 0) {
            setTimeout(showRandomPopup, randomTime); // Pastikan tetap berjalan jika produk ada
        }
    };

    showRandomPopup();
};

onMounted(() => {
    if (props.Products?.length > 0) {
        startOrderPopup();
    }
});
</script>
