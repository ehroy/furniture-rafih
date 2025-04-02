<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="relative flex flex-col items-center justify-center h-screen text-center bg-pattern"
    >
        <!-- Animasi "404" -->
        <h1 class="text-9xl font-extrabold text-red-500 animate-popIn">404</h1>

        <!-- Animasi Paragraf -->
        <p class="text-lg text-gray-600 mt-2 animate-fadeIn">
            {{ $t("errors.text") }}
        </p>

        <!-- Animasi Tombol -->
        <div class="mt-4">
            <Link
                href="/"
                class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 hover:shadow-lg"
            >
                {{ $t("homepage.back_home") }}
            </Link>
        </div>
    </div>
</template>

<style scoped>
/* Background Pattern */
.bg-pattern {
    background-color: #f3f4f6;
    background-image: url("https://www.transparenttextures.com/patterns/asfalt-light.png");
}

/* Efek Pop In */
@keyframes popIn {
    from {
        opacity: 0;
        transform: scale(0.5);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.animate-popIn {
    animation: popIn 0.6s ease-out;
}

/* Efek Fade In */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeIn {
    animation: fadeIn 1s ease-out;
}
</style>
