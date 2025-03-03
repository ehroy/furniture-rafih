<template>
    <JustHead :Global="Global" />
    <div class="py-24 px-5 md:px-20 lg:px-64 text-[#4A4A4A]">
        <div
            class="flex flex-col md:flex-row justify-start border-b-2 border-[#2E2E2E] md:w-4/12 md:text-sm"
        >
            <h1
                class="text-secondary text-xl text-center md:text-left md:text-4xl mb-5 md:mb-0 poppins-bold uppercase"
            >
                <i class="mdi mdi-image-multiple"></i> GALLERY
            </h1>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
            <div
                v-for="(item, index) in Gallery"
                :key="item.id"
                class="relative w-full rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300"
            >
                <img
                    :src="item.image"
                    class="w-full h-64 object-cover rounded-lg"
                    alt="Furniture Image"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 hover:opacity-100 flex items-end p-4 transition-opacity duration-300"
                >
                    <span class="text-white text-lg font-medium">
                        {{ item.subcategory.name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    Gallery: Object,
    Global: Object,
});
</script>

<style scoped>
img {
    transition: transform 0.3s ease-in-out;
}
img:hover {
    transform: scale(1.02);
}
</style>
