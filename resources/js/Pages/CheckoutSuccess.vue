<template>
    <JustHead :Global="Global" />
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-400 to-blue-500 p-6"
    >
        <div class="bg-white rounded-2xl shadow-xl p-8 max-w-3xl w-full">
            <h1 class="text-2xl font-bold text-green-600 text-center">
                🎉 Terima kasih! Pesanan Anda berhasil!
            </h1>
            <p class="mt-2 text-gray-600 text-center text-lg">
                Order Number:
                <span class="font-semibold">{{ order.order_number }}</span>
            </p>

            <p class="mt-4 text-gray-700 text-lg font-medium text-center">
                ✅ Tunggu email, admin akan segera menghubungi Anda.
            </p>

            <div class="border-t border-gray-300 my-6"></div>

            <h2 class="text-lg font-semibold text-gray-700">Detail Pesanan</h2>
            <ul class="mt-4 space-y-4">
                <li
                    v-for="item in order.items"
                    :key="item.id"
                    class="flex items-center bg-gray-100 rounded-lg p-4 shadow-sm"
                >
                    <img
                        :src="item.product.image_url"
                        alt="Produk"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-300"
                    />
                    <div class="ml-4">
                        <p class="text-gray-900 font-semibold">
                            {{ item.product.name }}
                        </p>
                        <p class="text-gray-600">
                            Kuantitas: {{ item.quantity }}
                        </p>
                    </div>
                </li>
            </ul>

            <div class="mt-6 text-center">
                <Link
                    href="/"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300"
                >
                    Kembali ke Beranda
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import JustHead from "../Components/JustHead.vue";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    Global: Object,
    order: Object,
});
</script>
