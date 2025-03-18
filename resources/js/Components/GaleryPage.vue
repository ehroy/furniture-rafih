<template>
    <section class="relative w-full h-screen">
        <img
            style="background-image: url('/assets/images/image_galery.webp')"
            alt="Furniture Showcase"
            class="absolute inset-0 w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div
            class="absolute inset-0 flex flex-col items-center justify-center text-center px-4"
        >
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                Elegance in Every Detail
            </h1>
            <p class="text-xl text-white max-w-xl mb-8">
                Koleksi furniture premium untuk ruang yang bermakna
            </p>
            <button
                class="bg-white text-gray-900 px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition"
            >
                Jelajahi Koleksi
            </button>
        </div>
    </section>
    <div class="py-24 px-5 md:px-20 lg:px-64 text-[#4A4A4A]">
        <div
            class="flex flex-col md:flex-row justify-start border-b-2 border-[#2E2E2E] md:w-4/12 md:text-sm"
        >
            <h1
                class="text-secondary text-xl text-center md:text-left md:text-4xl mb-5 md:mb-0 poppins-bold uppercase"
            >
                <i class="mdi mdi-image-multiple"></i> KOLEKSI
            </h1>
        </div>
        <section class="py-16 px-4 max-w-7xl mx-auto">
            <!-- Gallery Filter -->

            <!-- Gallery Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8"
            >
                <div
                    v-for="image in filteredCategories"
                    :key="image.id"
                    class="group relative overflow-hidden cursor-pointer rounded-lg aspect-square"
                    @click="openLightbox(image)"
                >
                    <!-- Thumbnail Image -->
                    <img
                        :src="helpers.imageUrl(image.image)"
                        :alt="image.subcategory.name"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    />

                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-300 flex items-end"
                    >
                        <div
                            class="p-4 w-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0"
                        >
                            <h2 class="text-white font-medium text-lg">
                                {{ image.subcategory.name }}
                            </h2>
                            <p class="text-white text-sm opacity-80">
                                {{ image.subcategory.category.name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <section class="bg-gray-50 py-16 px-4">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Transformasi Ruangan Anda
            </h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                Jadikan rumah Anda lebih elegan dengan furniture berkualitas
                tinggi. Konsultasi dengan desainer kami untuk mendapatkan
                pengalaman yang personal.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-4">
                <Link
                    href="/products"
                    class="bg-gray-900 text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition"
                >
                    Katalog Lengkap
                </Link>
                <button
                    class="bg-white border border-gray-300 text-gray-700 px-8 py-3 rounded-md font-medium hover:bg-gray-50 transition"
                >
                    Hubungi Kami
                </button>
            </div>
        </div>
        <Popup :Global="Global" :Products="Products" />
    </section>
</template>

<script setup>
import Popup from "./Popup.vue";
import { Link } from "@inertiajs/vue3";
import { inject, computed } from "vue";
const helpers = inject("helpers");
const props = defineProps({
    Categories: Object,
    Gallery: Object,
    Global: Object,
    Products: Object,
});
const filteredCategories = computed(() => {
    return props.Gallery.filter((category) => category.subcategory);
});
</script>

<style scoped>
img {
    transition: transform 0.3s ease-in-out;
}
img:hover {
    transform: scale(1.02);
}
</style>
