<template>
    <section class="bg-[#D4A373] py-10 px-5 md:py-20 md:px-64">
        <div class="border-b-2 border-gray-700 w-3/12">
            <h1 class="mt-5 mb-10 text-3xl poppins-bold uppercase">
                <i class="mdi mdi-star-circle"></i> Rekomendasi Produk
            </h1>
        </div>
        <br /><br />

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-10">
            <div
                class="rounded-lg"
                v-for="(product, index) in ProductsRecommended"
                :key="index"
            >
                <img
                    class="w-full rounded-t-lg"
                    :src="helpers.imageUrl(product.image)"
                    :alt="product.name"
                />
                <div
                    class="flex flex-col gap-2 text-gray-600 bg-gray-100 p-3 rounded-b-lg hover:shadow-lg"
                >
                    <Link :href="'/product/' + product.slug"
                        ><h4 class="font-bold hover:underline">
                            {{ product.name }}
                        </h4></Link
                    >

                    <div class="flex flex-col md:flex-row md:justify-between">
                        <b class="text-sm mt-2">{{
                            product.price == 0
                                ? "Tanya Admin"
                                : helpers.rupiah(product.price)
                        }}</b>
                        <span class="text-sm mt-2"
                            ><i class="mdi mdi-tag"></i>
                            {{ product.subcategory.name }}</span
                        >
                    </div>
                    <Link
                        :href="
                            helpers.WaButton(Global, '/product/' + product.slug)
                        "
                        class="bg-[#2E2E2E] px-8 py-2 rounded-full text-[#FAFAFA] font-bold text-center hover:bg-[#D4A373] hover:text-[#4A4A4A] uppercase text-lg md:text-lg"
                        target="_blank"
                        ><i class="mdi mdi-whatsapp"></i>
                        {{ Global.Settings.action_button_text }}</Link
                    >
                </div>
            </div>
        </div>
        <br /><br />
        <div class="flex justify-center">
            <Link
                href="/products?filter=recommended"
                class="bg-white p-2 rounded-full text-center text-gray-600 hover:outline mt-10"
                ><i class="mdi mdi-view-list"></i> Tampilkan Semua</Link
            >
        </div>
    </section>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { inject } from "vue";
const helpers = inject("helpers");
defineProps({ ProductsRecommended: Object, Global: Object });
</script>
