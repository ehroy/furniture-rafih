<template>
    <div id="categoryPage">
        <section class="flex flex-col gap-10 py-20">
            <!-- desktop -->
            <div class="hidden md:block">
                <div
                    class="flex justify-center items-center text-sm font-medium text-center text-[#2E2E2E] dark:text[#D4A373] dark:border-[#2E2E2E]"
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
                                :href="'?cat=' + cat.id"
                                :class="
                                    ActiveCat == cat.id
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
                    class="w-5/6 bg-transparent text-[#2E2E2E] border-0 border-b-2 border-b-[#2E2E2E] hover:border-b-600"
                    v-model="catModel"
                >
                    <option value="">
                        {{
                            ActiveCat == null
                                ? "Pilih Kategori"
                                : Categories.find((cat) => cat.id == ActiveCat)
                                      ?.name
                        }}
                    </option>
                    <option
                        v-for="(cat, index) in Categories"
                        :value="cat.id"
                        :key="index"
                    >
                        {{ cat.name }}
                    </option>
                </select>
            </div>

            <div
                class="flex flex-wrap justify-center gap-2 md:items-center md:gap-10"
            >
                <Link
                    :href="'?cat=' + ActiveCat + '&sub=' + sub.id"
                    v-for="(sub, index) in SubCategories"
                    :key="index"
                    preserve-scroll
                >
                    <div
                        class="flex flex-col items-center hover:sepia cursor-pointer"
                    >
                        <img
                            class="mb-3 w-20 md:w-48 rounded-full"
                            :src="helpers.imageUrl(sub.image)"
                            :alt="sub.name"
                        />
                        <h4 class="text-sm md:text-3xl">{{ sub.name }}</h4>
                    </div>
                </Link>
            </div>
        </section>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

defineProps({
    Categories: Object,
    SubCategories: Object,
    ActiveCat: String,
});

import { inject } from "vue";
const helpers = inject("helpers");
const catModel = ref("");

watch(catModel, async () => {
    router.visit("?cat=" + catModel.value, { preserveScroll: true });
});
</script>
