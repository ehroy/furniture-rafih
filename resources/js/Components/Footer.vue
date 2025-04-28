<template>
    <div class="hidden md:block">
        <footer
            class="flex flex-col border-t-2 bg-[#424242] text-gray-50 to-transparent"
        >
            <div
                class="flex justify-between gap-10 py-20 px-64 bg-primary bg-[url('/public/assets/images/dots.png')] bg-cover"
            >
                <nav>
                    <h1 class="font-bold text-2xl mb-8">
                        {{ $t("product.kami") }}
                    </h1>
                    <ul class="flex flex-col gap-3">
                        <li>
                            <Link href="/products?filter=all">
                                {{ $t("product.all") }}</Link
                            >
                        </li>
                        <li>
                            <Link href="/products?filter=populer">{{
                                $t("product.laris")
                            }}</Link>
                        </li>
                        <li>
                            <Link href="/products?filter=new">{{
                                $t("product.new1")
                            }}</Link>
                        </li>
                    </ul>
                </nav>

                <nav>
                    <h1 class="font-bold text-2xl mb-8">{{ $t("halaman") }}</h1>
                    <ul class="flex flex-col gap-3">
                        <li><Link href="/galery">Gallery</Link></li>
                        <li><Link href="/contact">Call Me</Link></li>
                    </ul>
                </nav>

                <nav>
                    <h1 class="font-bold text-2xl mb-8">SOCIAL MEDIA</h1>
                    <div class="flex gap-5 mb-3">
                        <Link
                            v-for="(sos, index) in Socmed"
                            :key="index"
                            :href="sos.link"
                            :target="'_blank'"
                            :class="classNames[sos.type]"
                            :aria-label="`visit ${sos.type}`"
                        >
                            <i :class="icons[sos.type]"></i>
                        </Link>
                    </div>
                    <p class="text-lg max-w-sm">
                        {{ $t("footer.text") }}
                    </p>
                </nav>
            </div>

            <div class="flex justify-center gap-10 py-3 font-bold text-xs">
                <span
                    >TERATAI FURNITURE &copy; {{ new Date().getFullYear() }}.
                    All rights reserved.
                </span>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
defineProps({ Global: Object, Socmed: Object, Pages: Object });
const icons = ref({
    tiktok: "mdi mdi-music-note-eighth",
    instagram: "mdi mdi-instagram",
    facebook: "mdi mdi-facebook",
    twitter: "mdi mdi-twitter",
    whatsapp: "mdi mdi-whatsapp",
    youtube: "mdi mdi-youtube",
});
const classNames = ref({
    tiktok: "px-3 py-2 bg-gray-600 text-white rounded text-xl hover:bg-gray-500",
    instagram:
        "px-3 py-2 bg-pink-600 text-white rounded text-xl hover:bg-pink-500",
    facebook:
        "px-3 py-2 bg-blue-600 text-white rounded text-xl hover:bg-blue-500",
    twitter:
        "px-3 py-2 bg-gray-600 text-white rounded text-xl hover:bg-gray-500",
    whatsapp:
        "px-3 py-2 bg-green-600 text-white rounded text-xl hover:bg-green-500",
    youtube: "px-3 py-2 bg-red-600 text-white rounded text-xl hover:bg-red-500",
});
</script>
