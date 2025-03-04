<template>
    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <section class="relative w-full h-screen">
            <img
                style="
                    background-image: url('/assets/images/image_galery.jpeg');
                "
                alt="Furniture Showcase"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div
                class="absolute inset-0 flex flex-col items-center justify-center text-center px-4"
            >
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                    Elegance in Every Detail
                </h1>
                <p class="text-xl text-white max-w-xl mb-8">
                    Koleksi furniture premium untuk ruang yang bermakna
                </p>
                <button
                    class="bg-white text-gray-900 px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition"
                >
                    Jelajahi Koleksi
                </button>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="py-16 px-4 max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Koleksi Kami</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">
                    Furniture dengan desain kontemporer yang menyatu dengan
                    keindahan dan fungsi untuk menciptakan ruang yang sempurna
                </p>
            </div>

            <!-- Gallery Filter -->
            <div class="flex justify-center mb-10">
                <div class="flex flex-wrap justify-center gap-2">
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        @click="activeCategory = category.id"
                        class="px-4 py-2 text-sm rounded-full transition-colors"
                        :class="
                            activeCategory === category.id
                                ? 'bg-gray-900 text-white'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                        "
                    >
                        {{ category.name }}
                    </button>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-8"
            >
                <div
                    v-for="image in filteredImages"
                    :key="image.id"
                    class="group relative overflow-hidden cursor-pointer rounded-lg aspect-square"
                    @click="openLightbox(image)"
                >
                    <!-- Thumbnail Image -->
                    <img
                        :src="image.thumbnail"
                        :alt="image.title"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    />

                    <!-- Overlay -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-300 flex items-end"
                    >
                        <div
                            class="p-4 w-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0"
                        >
                            <h3 class="text-white font-medium text-lg">
                                {{ image.title }}
                            </h3>
                            <p class="text-white text-sm opacity-80">
                                {{ image.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="bg-gray-50 py-16 px-4">
            <div class="max-w-5xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Transformasi Ruangan Anda
                </h2>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Jadikan rumah Anda lebih elegan dengan furniture berkualitas
                    tinggi. Konsultasi dengan desainer kami untuk mendapatkan
                    pengalaman yang personal.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button
                        class="bg-gray-900 text-white px-8 py-3 rounded-md font-medium hover:bg-gray-800 transition"
                    >
                        Katalog Lengkap
                    </button>
                    <button
                        class="bg-white border border-gray-300 text-gray-700 px-8 py-3 rounded-md font-medium hover:bg-gray-50 transition"
                    >
                        Hubungi Kami
                    </button>
                </div>
            </div>
        </section>

        <!-- Lightbox Modal -->
        <div
            v-if="lightbox.visible"
            class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4"
            @click="closeLightbox"
        >
            <div class="relative max-w-5xl max-h-[90vh] w-full" @click.stop>
                <!-- Close Button -->
                <button
                    @click="closeLightbox"
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-8 w-8"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

                <!-- Navigation Buttons -->
                <button
                    @click.stop="navigateLightbox('prev')"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-16 text-white hover:text-gray-300 transition hidden md:block"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>

                <button
                    @click.stop="navigateLightbox('next')"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-16 text-white hover:text-gray-300 transition hidden md:block"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </button>

                <!-- Lightbox Image -->
                <img
                    :src="lightbox.currentImage?.fullsize"
                    :alt="lightbox.currentImage?.title"
                    class="w-full h-auto max-h-[80vh] object-contain mx-auto"
                />

                <!-- Image Caption -->
                <div class="text-center text-white mt-4">
                    <h3 class="text-xl font-medium">
                        {{ lightbox.currentImage?.title }}
                    </h3>
                    <p class="text-gray-300 mt-1">
                        {{ lightbox.currentImage?.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

// State
const activeCategory = ref("all");

// Data
const categories = [
    { id: "all", name: "Semua" },
    { id: "living-room", name: "Ruang Tamu" },
    { id: "bedroom", name: "Kamar Tidur" },
    { id: "dining", name: "Ruang Makan" },
    { id: "office", name: "Kantor" },
];

const images = [
    {
        id: 1,
        categoryId: "living-room",
        title: "Modern Living Space",
        description: "Ruang tamu minimalis dengan sofa premium",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 2,
        categoryId: "bedroom",
        title: "Serene Bedroom",
        description: "Desain kamar tidur dengan nuansa tenang",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 3,
        categoryId: "dining",
        title: "Elegant Dining Set",
        description: "Set meja makan untuk pertemuan keluarga",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 4,
        categoryId: "office",
        title: "Professional Workspace",
        description: "Ruang kerja dengan desain ergonomis",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 5,
        categoryId: "living-room",
        title: "Scandinavian Design",
        description: "Konsep ruang tamu dengan sentuhan Skandinavia",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 6,
        categoryId: "bedroom",
        title: "Luxury Bed Collection",
        description: "Koleksi tempat tidur dengan bahan premium",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 7,
        categoryId: "dining",
        title: "Industrial Kitchen",
        description: "Kabinet dapur dengan gaya industrial",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 8,
        categoryId: "office",
        title: "Minimalist Desk",
        description: "Meja kerja minimalis untuk produktivitas",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
    {
        id: 9,
        categoryId: "living-room",
        title: "Accent Chairs",
        description: "Kursi aksen untuk sudut ruang tamu",
        thumbnail: "/api/placeholder/600/600",
        fullsize: "/api/placeholder/1200/800",
    },
];

// Lightbox state
const lightbox = ref({
    visible: false,
    currentImage: null,
    currentIndex: 0,
});

// Computed
const filteredImages = computed(() => {
    if (activeCategory.value === "all") {
        return images;
    }
    return images.filter((image) => image.categoryId === activeCategory.value);
});

// Methods
const openLightbox = (image) => {
    lightbox.value.currentImage = image;
    lightbox.value.currentIndex = filteredImages.value.findIndex(
        (img) => img.id === image.id
    );
    lightbox.value.visible = true;
    document.body.style.overflow = "hidden"; // Disable scrolling
};

const closeLightbox = () => {
    lightbox.value.visible = false;
    document.body.style.overflow = ""; // Re-enable scrolling
};

const navigateLightbox = (direction) => {
    const imagesLength = filteredImages.value.length;
    if (imagesLength <= 1) return;

    let newIndex;
    if (direction === "next") {
        newIndex = (lightbox.value.currentIndex + 1) % imagesLength;
    } else {
        newIndex =
            (lightbox.value.currentIndex - 1 + imagesLength) % imagesLength;
    }

    lightbox.value.currentIndex = newIndex;
    lightbox.value.currentImage = filteredImages.value[newIndex];
};
</script>
