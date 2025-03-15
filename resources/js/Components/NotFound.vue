<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="flex flex-col items-center justify-center h-screen text-center">
        <h1 class="text-6xl font-bold text-red-500">404</h1>
        <p class="text-lg text-gray-600">Oops! Halaman tidak ditemukan.</p>
        <Link href="/" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded"
            >Kembali ke Beranda</Link
        >
    </div>
</template>
