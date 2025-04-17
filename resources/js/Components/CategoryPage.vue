<template>
    <div id="categoryPage">
        <section class="flex flex-col gap-10 py-20">
            <!-- desktop -->
            <div class="hidden md:block">
                <div
                    class="flex justify-center items-center text-md font-medium text-center text-[#2E2E2E] dark:text[#D4A373] dark:border-[#2E2E2E]"
                >
                    <ul
                        class="flex flex-wrap -mb-px border-b-2 border-gray-300"
                    >
                        <li
                            class="me-2"
                            v-for="(cat, index) in Categories"
                            :key="index"
                        >
                            <Link
                                :href="'?category=' + cat.slug"
                                :class="
                                    ActiveCat == cat.slug
                                        ? 'inline-block p-4 border-2 border-transparent  bg-[#2E2E2E] text-gray-100'
                                        : 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-[#2E2E2E] hover:border-gray-300 dark:hover:text-gray-300'
                                "
                                preserve-scroll
                                >{{ cat.name }}</Link
                            >
                        </li>
                    </ul>
                </div>
            </div>

            <!-- mobile -->
            <div
                class="flex items-center justify-center md:hidden"
                preserver-scroll
            >
                <select
                    aria-label="Select categori"
                    class="w-5/6 bg-transparent text-[#2E2E2E] border-0 border-b-2 border-b-[#2E2E2E] hover:border-b-600"
                    v-model="catModel"
                >
                    <option value="">
                        {{ "Pick a Category" }}
                    </option>
                    <option
                        v-for="(cat, index) in Categories"
                        :value="cat.slug"
                        :key="index"
                    >
                        {{ cat.name }}
                    </option>
                </select>
            </div>
            <div class="relative w-full">
                <!-- Tombol Navigasi -->
                <button
                    @click="prevSlide"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white p-2 rounded-full"
                >
                    ◀
                </button>
                <!-- Swiper Slider -->
                <swiper
                    ref="swiperRef"
                    :modules="[Navigation]"
                    :slides-per-view="slidesPerView"
                    :space-between="10"
                    class="w-full"
                >
                    <swiper-slide
                        v-for="sub in SubCategories"
                        :key="sub.id"
                        class="w-32 md:w-48"
                    >
                        <Link
                            :href="
                                ActiveCat
                                    ? '?category=' +
                                      ActiveCat +
                                      '&subcategory=' +
                                      sub.slug
                                    : '/'
                            "
                            preserve-scroll
                        >
                            <div
                                class="flex flex-col items-center hover:sepia cursor-pointer"
                            >
                                <img
                                    class="mb-3 w-24 h-24 md:w-48 md:h-48 object-cover rounded-full"
                                    :src="helpers.imageUrl(sub.image)"
                                    alt=""
                                />
                                <h1 class="text-sm md:text-xl text-center">
                                    {{ sub.name }}
                                </h1>
                            </div>
                        </Link>
                    </swiper-slide>
                </swiper>

                <!-- Tombol Navigasi -->
                <button
                    @click="nextSlide"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white p-2 rounded-full"
                >
                    ▶
                </button>
            </div>
        </section>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch, inject, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation } from "swiper/modules";
import "swiper/css";
const active = ref(null);
const swiperRef = ref(null);

const props = defineProps({
    Categories: Object,
    SubCategories: Object,
    ActiveCat: String,
});

const helpers = inject("helpers");
const catModel = ref("");
const slidesPerView = computed(() => {
    if (window.innerWidth >= 1024) return 4; // Desktop: 4 item
    if (window.innerWidth >= 768) return 3; // Tablet: 3 item
    return 2; // Mobile: 2 item
});
const prevSlide = () => {
    swiperRef.value?.$el.swiper.slidePrev();
};

const nextSlide = () => {
    swiperRef.value?.$el.swiper.slideNext();
};
watch(catModel, async () => {
    router.visit("?category=" + catModel.value, { preserveScroll: true });
});
</script>
<style scoped>
.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
