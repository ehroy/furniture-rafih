<template>
    <JustHead :Global="Global" />
    <div>
        <Navbar :Categories="Categories" />

        <div class="relative w-full h-screen flex justify-center items-center">
            <!-- Background Image -->
            <img 
                class="absolute inset-0 w-full h-full object-cover"
                src="/assets/images/home.webp"
                alt="Hero background"
                type="image/webp"
                loading="lazy"
                >
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            </img>

            <!-- Teks di atas background -->
            <div class="relative z-10 text-center text-white px-5">
                <h1 class="text-5xl md:text-6xl font-bold animate-pulse">
                    TERATAI FURNITURE
                </h1>
                    <main>
                    <p class="text-lg md:text-xl mt-4 w-full md:w-3/4 mx-auto">
                        Kami menghadirkan desain interior minimalis dengan sentuhan
                        alami. Menggunakan material kayu berkualitas, setiap
                        furnitur dirancang fungsional, estetik, dan tahan lama.
                        Sederhana, elegan, dan menyatu dengan kehidupan Anda.
                    </p>
                </main>

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
            <b>&copy; TERATAI FURNITURE</b> |
            <i class="italic">Langon tahunan, Jepara, Jawa Tengah</i>
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
            :Products="Products"
        />
        <Testimonial :Testimonials="Testimonials" />
        <Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
        <Popup :Global="Global" :Products="Products" />
    </div>
</template>

<script setup>
import Popup from "../Components/Popup.vue";
import Navbar from "../Components/Navbar.vue";
import CategoryPage from "../Components/CategoryPage.vue";
import Testimonial from "../Components/Testimonial.vue";
import ProductPage from "../Components/ProductPage.vue";
import GaleryPage from "../Components/GaleryPage.vue";
import Footer from "../Components/Footer.vue";
import JustHead from "../Components/JustHead.vue";
import { Link } from "@inertiajs/vue3";
import { inject, ref, onMounted } from "vue";
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

onMounted(() => {
    document.getElementById("app")?.removeAttribute("data-page");
});
const HeadTitle = "Produk Kami";
const Action = "all";
</script>
