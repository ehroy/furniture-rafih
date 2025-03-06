<template>
    <JustHead :Global="Global" />
    <div>
        <Navbar :Categories="Categories" />
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
        <div class="relative w-full h-screen flex justify-center items-center">
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('/assets/images/home.jpg')"
            >
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </div>

            <!-- Teks di atas background -->
            <div class="relative z-10 text-center text-white px-5">
                <h1 class="text-5xl md:text-8xl font-bold animate-pulse">
                    NAME FURNITURE
                </h1>
                <p class="text-lg md:text-xl mt-4 w-full md:w-3/4 mx-auto">
                    Kami menghadirkan desain interior minimalis dengan sentuhan
                    alami. Menggunakan material kayu berkualitas, setiap
                    furnitur dirancang fungsional, estetik, dan tahan lama.
                    Sederhana, elegan, dan menyatu dengan kehidupan Anda.
                </p>

                <div class="mt-5">
                    <Link
                        href="/products"
                        class="bg-[#2E2E2E] p-3 rounded text-[#F5F5F5] hover:bg-[#424141] inline-block"
                    >
                        Belanja sekarang!
                    </Link>
                </div>
            </div>
        </div>
        <div class="text-center px-5 py-5">
            <b>&copy; NAME FURNITURE</b> |
            <i class="italic">Bawu Batealit, Jepara, Jawa Tengah</i>
        </div>

        <CategoryPage
            :Categories="Categories"
            :SubCategories="SubCategories"
            :ActiveCat="ActiveCat"
        />

        <ProductPage
            :Products="Products"
            :HeadTitle="HeadTitle"
            :Action="Action"
            :Filter="Filter"
            :Global="Global"
            :FilterQuery="FilterQuery"
        />
        <GaleryPage
            :Gallery="Gallery"
            :Global="Global"
            :Categories="Categories"
        />
        <Testimonial :Testimonials="Testimonials" />

        <Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
    </div>
</template>

<script setup>
import Navbar from "../Components/Navbar.vue";
import CategoryPage from "../Components/CategoryPage.vue";
import Testimonial from "../Components/Testimonial.vue";
import ProductPage from "../Components/ProductPage.vue";
import RecommendedPage from "../Components/RecommendedPage.vue";
import GaleryPage from "../Components/GaleryPage.vue";
import Footer from "../Components/Footer.vue";
import JustHead from "../Components/JustHead.vue";
import { Link } from "@inertiajs/vue3";
import { inject, ref } from "vue";
const helpers = inject("helpers");
const props = defineProps({
    Gallery: Object,
    ProductsRecommended: Object,
    Products: Object,
    Categories: Object,
    SubCategories: Object,
    ActiveCat: String,
    Filter: String,
    Global: Object,
    Testimonials: Object,
    Socmed: Object,
    Pages: Object,
    FilterQuery: String,
});
if (props.Products[0]?.variants?.length > 0) {
    console.log("Variants tersedia:", props.Products[0].variants.length);
} else {
    console.log("Tidak ada variants.");
}

const HeadTitle = "Produk Kami";
const Action = "all";
</script>
