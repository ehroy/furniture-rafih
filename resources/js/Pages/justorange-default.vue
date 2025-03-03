<template>
    <JustHead :Global="Global" />
    <div>
        <Navbar :Categories="Categories" />

        <!-- Mode Desktop
        <div class="hidden md:block relative">
            <section class="grid grid-cols-2 gap-4 p-10">
                <div class="flex flex-col justify-center">
                    <div class="flex flex-col items-start">
                        <h1
                            class="text-8xl font-bold w-2/3 mb-5 poppins-bold animate-pulse"
                        >
                            <span class="text-gray-600">IA PROJECT</span>
                        </h1>

                        <p class="text-secondary w-3/4 text-lg p-2">
                            Kami bergerak di bidang desain interior dan
                            penyediaan furniture berkualitas. Dengan tim ahli
                            bidang kayu dan konstruksi furniture yang estetik
                            dan tahan lama untuk berbagai kebutuhan desain
                            interior maupun eksterior.
                        </p>
                    </div>

                    <div class="mt-5 px-32">
                        <a
                            href="/products"
                            class="bg-[#2E2E2E] p-3 rounded text-[#F5F5F5] hover:bg-[#D4A373] hover:text-[#4A4A4A] mt-5 inline-block"
                        >
                            Belanja sekarang!
                        </a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <img
                        src="/assets/images/home.jpg"
                        alt="Furniture"
                        class="hover:sepia w-auto mt-6"
                    />
                </div>
            </section>

            <div class="text-center px-5 py-5">
                <b>&copy; IA PROJECT</b> |
                <i class="italic">Bawu Batealit, Jepara, Jawa Tengah</i>
            </div>
        </div>

        <!-- Mode Mobile -->
        <!-- <div class="block md:hidden relative">
            <section class="grid grid-cols-1 gap-4 p-5">
                <div class="flex flex-col items-center text-center">
                    <h1
                        class="text-4xl font-bold mb-5 poppins-bold animate-pulse"
                    >
                        <span class="text-gray-600">IA PROJECT</span>
                    </h1>

                    <p class="text-secondary text-lg p-2">
                        Kami bergerak di bidang desain interior dan penyediaan
                        furniture berkualitas. Dengan tim ahli bidang kayu dan
                        konstruksi furniture yang estetik dan tahan lama untuk
                        berbagai kebutuhan desain interior maupun eksterior.
                    </p>

                    <div class="mt-5">
                        <a
                            href="/products"
                            class="bg-[#2E2E2E] p-3 rounded text-[#F5F5F5] hover:bg-[#D4A373] hover:text-[#4A4A4A] mt-5 inline-block"
                        >
                            Belanja sekarang!
                        </a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <img
                        src="/assets/images/home.jpg"
                        alt="Furniture"
                        class="hover:sepia w-3/4 mt-6"
                    />
                </div>
            </section>

            <div class="text-center px-5 py-5">
                <b>&copy; IA PROJECT</b> |
                <i class="italic">Bawu Batealit, Jepara, Jawa Tengah</i>
            </div>
        </div> -->
        -->
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
                    <a
                        href="/products"
                        class="bg-[#2E2E2E] p-3 rounded text-[#F5F5F5] hover:bg-[#424141] inline-block"
                    >
                        Belanja sekarang!
                    </a>
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
        <GaleryPage :Gallery="Gallery" :Global="Global" />
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

defineProps({
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
const HeadTitle = "Produk Kami";
const Action = "all";
</script>
