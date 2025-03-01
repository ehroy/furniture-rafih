<template>
    <JustHead :Global="Global" />
    <div class="px-5 md:px-20 lg:px-64 text-[#4A4A4A]">
        <div
            class="flex flex-col md:flex-row justify-start border-b-2 border-[#2E2E2E] md:w-4/12 md:text-sm"
        >
            <h1
                class="text-secondary text-xl text-center md:text-left md:text-4xl mb-5 md:mb-0 poppins-bold uppercase"
            >
                <i class="mdi mdi-image-multiple"></i> GALLERY
            </h1>
        </div>
        <br /><br />
        <div
            class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 xl:columns-6 gap-4 p-4"
        >
            <div
                v-for="(item, index) in Gallery"
                :key="item.id"
                class="relative w-full mb-4 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300"
            >
                <img
                    :src="item.image"
                    class="w-full object-cover rounded-lg"
                    :class="randomHeight()"
                    alt="Furniture Image"
                />
                <div
                    class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-50 flex justify-center items-center transition-all duration-300 group"
                >
                    <span
                        class="text-white text-lg font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    >
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

const randomHeight = () => {
    const heights = ["h-40", "h-52", "h-64"];
    return heights[Math.floor(Math.random() * heights.length)];
};
</script>

<style scoped>
img:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease-in-out;
}
</style>
