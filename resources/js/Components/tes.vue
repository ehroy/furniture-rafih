<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Header -->
        <header class="max-w-7xl mx-auto mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                Galeri Furniture
            </h1>
            <p class="text-gray-600 mt-2">
                Temukan koleksi furniture berkualitas untuk rumah Anda
            </p>
        </header>

        <!-- Filter Section -->
        <div class="max-w-7xl mx-auto mb-8">
            <div
                class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-lg shadow-sm"
            >
                <!-- Kategori -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Kategori</label
                    >
                    <select
                        v-model="selectedCategory"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="all">Semua Kategori</option>
                        <option value="living-room">Ruang Tamu</option>
                        <option value="bedroom">Kamar Tidur</option>
                        <option value="dining">Ruang Makan</option>
                        <option value="office">Kantor</option>
                    </select>
                </div>

                <!-- Material -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Material</label
                    >
                    <select
                        v-model="selectedMaterial"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="all">Semua Material</option>
                        <option value="wood">Kayu</option>
                        <option value="metal">Logam</option>
                        <option value="fabric">Kain</option>
                        <option value="glass">Kaca</option>
                    </select>
                </div>

                <!-- Harga -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Rentang Harga</label
                    >
                    <select
                        v-model="selectedPriceRange"
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="all">Semua Harga</option>
                        <option value="low">< Rp 1.000.000</option>
                        <option value="medium">
                            Rp 1.000.000 - Rp 5.000.000
                        </option>
                        <option value="high">
                            Rp 5.000.000 - Rp 10.000.000
                        </option>
                        <option value="premium">> Rp 10.000.000</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="max-w-7xl mx-auto">
            <!-- Loading state -->
            <div v-if="loading" class="flex justify-center items-center py-10">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"
                ></div>
            </div>

            <!-- Empty state -->
            <div
                v-else-if="filteredFurniture.length === 0"
                class="bg-white rounded-lg shadow-sm p-10 text-center"
            >
                <p class="text-gray-600 text-lg">
                    Tidak ada furniture yang sesuai dengan filter yang dipilih.
                </p>
                <button
                    @click="resetFilters"
                    class="mt-4 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition"
                >
                    Reset Filter
                </button>
            </div>

            <!-- Gallery Grid -->
            <div
                v-else
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <div
                    v-for="item in filteredFurniture"
                    :key="item.id"
                    class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform duration-300 hover:shadow-md hover:-translate-y-1"
                >
                    <div class="relative pb-[70%] overflow-hidden bg-gray-100">
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="absolute h-full w-full object-cover"
                        />
                        <div class="absolute top-2 right-2">
                            <span
                                class="inline-block px-2 py-1 text-xs font-medium rounded-full"
                                :class="{
                                    'bg-red-100 text-red-800':
                                        item.priceCategory === 'premium',
                                    'bg-orange-100 text-orange-800':
                                        item.priceCategory === 'high',
                                    'bg-blue-100 text-blue-800':
                                        item.priceCategory === 'medium',
                                    'bg-green-100 text-green-800':
                                        item.priceCategory === 'low',
                                }"
                            >
                                {{ formatPriceTag(item.priceCategory) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ item.name }}
                            </h3>
                            <span class="text-sm font-medium text-gray-500">{{
                                item.categoryLabel
                            }}</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">
                            {{ item.material }}
                        </p>
                        <p class="font-semibold text-gray-900 mt-2">
                            {{ formatPrice(item.price) }}
                        </p>

                        <div class="mt-4 flex justify-between items-center">
                            <button
                                class="bg-indigo-600 text-white px-3 py-1.5 rounded text-sm font-medium hover:bg-indigo-700 transition"
                                @click="viewDetails(item)"
                            >
                                Detail
                            </button>
                            <button
                                class="text-indigo-600 hover:text-indigo-800 transition"
                                @click="toggleFavorite(item)"
                            >
                                <svg
                                    v-if="favorites.includes(item.id)"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk detail -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
        >
            <div
                class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-auto"
            >
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ selectedFurniture.name }}
                    </h2>
                    <button
                        @click="showModal = false"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
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
                </div>
                <div class="p-4 md:flex gap-6">
                    <div class="md:w-1/2">
                        <img
                            :src="selectedFurniture.image"
                            :alt="selectedFurniture.name"
                            class="w-full h-auto rounded-lg"
                        />
                    </div>
                    <div class="md:w-1/2 mt-4 md:mt-0">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="inline-block px-2 py-1 text-xs font-medium rounded-full"
                                :class="{
                                    'bg-red-100 text-red-800':
                                        selectedFurniture.priceCategory ===
                                        'premium',
                                    'bg-orange-100 text-orange-800':
                                        selectedFurniture.priceCategory ===
                                        'high',
                                    'bg-blue-100 text-blue-800':
                                        selectedFurniture.priceCategory ===
                                        'medium',
                                    'bg-green-100 text-green-800':
                                        selectedFurniture.priceCategory ===
                                        'low',
                                }"
                            >
                                {{
                                    formatPriceTag(
                                        selectedFurniture.priceCategory
                                    )
                                }}
                            </span>
                            <span class="text-sm font-medium text-gray-500">{{
                                selectedFurniture.categoryLabel
                            }}</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ formatPrice(selectedFurniture.price) }}
                        </h3>
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-700">
                                Detail Produk
                            </h4>
                            <p class="mt-2 text-gray-600">
                                {{ selectedFurniture.description }}
                            </p>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <div>
                                    <span class="text-sm text-gray-500"
                                        >Material</span
                                    >
                                    <p class="font-medium">
                                        {{ selectedFurniture.material }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500"
                                        >Dimensi</span
                                    >
                                    <p class="font-medium">
                                        {{ selectedFurniture.dimensions }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500"
                                        >Ketersediaan</span
                                    >
                                    <p class="font-medium">
                                        {{
                                            selectedFurniture.stock > 0
                                                ? "Tersedia"
                                                : "Habis"
                                        }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500"
                                        >Waktu Pengiriman</span
                                    >
                                    <p class="font-medium">
                                        {{ selectedFurniture.deliveryTime }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-4">
                            <button
                                class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition font-medium"
                            >
                                Tambah ke Keranjang
                            </button>
                            <button
                                class="p-2 text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50 transition"
                                @click="toggleFavorite(selectedFurniture)"
                            >
                                <svg
                                    v-if="
                                        favorites.includes(selectedFurniture.id)
                                    "
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: true,
            furniture: [],
            selectedCategory: "all",
            selectedMaterial: "all",
            selectedPriceRange: "all",
            favorites: [],
            showModal: false,
            selectedFurniture: {},
        };
    },
    computed: {
        filteredFurniture() {
            return this.furniture.filter((item) => {
                // Filter kategori
                const categoryMatch =
                    this.selectedCategory === "all" ||
                    item.category === this.selectedCategory;

                // Filter material
                const materialMatch =
                    this.selectedMaterial === "all" ||
                    item.material.toLowerCase().includes(this.selectedMaterial);

                // Filter harga
                const priceMatch =
                    this.selectedPriceRange === "all" ||
                    item.priceCategory === this.selectedPriceRange;

                return categoryMatch && materialMatch && priceMatch;
            });
        },
    },
    mounted() {
        // Simulasi loading data
        setTimeout(() => {
            this.loadFurnitureData();
            this.loading = false;
        }, 800);

        // Load favorit dari local storage jika ada
        const savedFavorites = localStorage.getItem("furniture-favorites");
        if (savedFavorites) {
            this.favorites = JSON.parse(savedFavorites);
        }
    },
    methods: {
        loadFurnitureData() {
            // Contoh data furniture
            this.furniture = [
                {
                    id: 1,
                    name: "Sofa Minimalis 3 Seater",
                    category: "living-room",
                    categoryLabel: "Ruang Tamu",
                    material: "Kain Linen",
                    price: 4500000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 12,
                    dimensions: "220 x 85 x 75 cm",
                    deliveryTime: "7-14 hari",
                    description:
                        "Sofa minimalis dengan desain Skandinavia yang nyaman. Dilengkapi dengan bantal dan sandaran yang empuk. Cocok untuk ruang tamu modern.",
                },
                {
                    id: 2,
                    name: "Meja Makan Bundar",
                    category: "dining",
                    categoryLabel: "Ruang Makan",
                    material: "Kayu Jati",
                    price: 6800000,
                    priceCategory: "high",
                    image: "/api/placeholder/800/600",
                    stock: 5,
                    dimensions: "Diameter 120 cm x 75 cm",
                    deliveryTime: "14-21 hari",
                    description:
                        "Meja makan bundar terbuat dari kayu jati solid dengan finishing natural. Desain klasik yang cocok untuk berbagai gaya interior.",
                },
                {
                    id: 3,
                    name: "Tempat Tidur Platform",
                    category: "bedroom",
                    categoryLabel: "Kamar Tidur",
                    material: "Kayu Oak",
                    price: 8500000,
                    priceCategory: "high",
                    image: "/api/placeholder/800/600",
                    stock: 3,
                    dimensions: "180 x 200 x 40 cm",
                    deliveryTime: "14-21 hari",
                    description:
                        "Tempat tidur platform modern dengan headboard minimalis. Terbuat dari kayu oak premium dengan finishing natural oil.",
                },
                {
                    id: 4,
                    name: "Lemari Pakaian Sliding",
                    category: "bedroom",
                    categoryLabel: "Kamar Tidur",
                    material: "Kayu & Kaca",
                    price: 12500000,
                    priceCategory: "premium",
                    image: "/api/placeholder/800/600",
                    stock: 2,
                    dimensions: "200 x 60 x 240 cm",
                    deliveryTime: "21-30 hari",
                    description:
                        "Lemari pakaian dengan pintu sliding kaca. Fitur interior yang lengkap dengan rak, gantungan, dan laci.",
                },
                {
                    id: 5,
                    name: "Meja Kerja Minimalis",
                    category: "office",
                    categoryLabel: "Kantor",
                    material: "Kayu & Logam",
                    price: 3200000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 8,
                    dimensions: "120 x 60 x 75 cm",
                    deliveryTime: "7-14 hari",
                    description:
                        "Meja kerja dengan desain minimalis. Kombinasi material kayu dengan kaki logam. Dilengkapi dengan laci penyimpanan.",
                },
                {
                    id: 6,
                    name: "Kursi Kantor Ergonomis",
                    category: "office",
                    categoryLabel: "Kantor",
                    material: "Mesh & Logam",
                    price: 2800000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 15,
                    dimensions: "65 x 65 x 115 cm",
                    deliveryTime: "3-7 hari",
                    description:
                        "Kursi kantor dengan desain ergonomis. Sandaran dan dudukan yang nyaman dengan material mesh breathable. Dilengkapi fitur adjustable height.",
                },
                {
                    id: 7,
                    name: "Coffee Table Industrial",
                    category: "living-room",
                    categoryLabel: "Ruang Tamu",
                    material: "Kayu & Besi",
                    price: 1800000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 7,
                    dimensions: "120 x 60 x 45 cm",
                    deliveryTime: "7-14 hari",
                    description:
                        "Meja kopi dengan gaya industrial. Kombinasi kayu reclaimed dan rangka besi yang kokoh.",
                },
                {
                    id: 8,
                    name: "Kursi Makan Set 4",
                    category: "dining",
                    categoryLabel: "Ruang Makan",
                    material: "Kayu & Kain",
                    price: 4200000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 3,
                    dimensions: "45 x 45 x 90 cm (per kursi)",
                    deliveryTime: "7-14 hari",
                    description:
                        "Set 4 kursi makan dengan desain Skandinavia. Rangka kayu solid dengan dudukan berlapis kain linen yang nyaman.",
                },
                {
                    id: 9,
                    name: "Rak Buku Modular",
                    category: "living-room",
                    categoryLabel: "Ruang Tamu",
                    material: "Kayu Lapis",
                    price: 2500000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 10,
                    dimensions: "180 x 35 x 200 cm",
                    deliveryTime: "7-14 hari",
                    description:
                        "Rak buku modular yang dapat disesuaikan. Terdiri dari beberapa modul yang dapat diatur sesuai kebutuhan.",
                },
                {
                    id: 10,
                    name: "Single Sofa",
                    category: "living-room",
                    categoryLabel: "Ruang Tamu",
                    material: "Kulit Sintetis",
                    price: 2900000,
                    priceCategory: "medium",
                    image: "/api/placeholder/800/600",
                    stock: 6,
                    dimensions: "80 x 85 x 90 cm",
                    deliveryTime: "7-14 hari",
                    description:
                        "Single sofa dengan material kulit sintetis premium. Nyaman dan cocok untuk sudut baca atau pelengkap sofa utama.",
                },
                {
                    id: 11,
                    name: "Meja Nakas",
                    category: "bedroom",
                    categoryLabel: "Kamar Tidur",
                    material: "Kayu Mahoni",
                    price: 850000,
                    priceCategory: "low",
                    image: "/api/placeholder/800/600",
                    stock: 20,
                    dimensions: "45 x 40 x 55 cm",
                    deliveryTime: "3-7 hari",
                    description:
                        "Meja nakas minimalis dengan laci penyimpanan. Cocok diletakkan di samping tempat tidur.",
                },
                {
                    id: 12,
                    name: "Kabinet Dapur",
                    category: "dining",
                    categoryLabel: "Dapur",
                    material: "Plywood & HPL",
                    price: 15000000,
                    priceCategory: "premium",
                    image: "/api/placeholder/800/600",
                    stock: 2,
                    dimensions: "240 x 60 x 80 cm",
                    deliveryTime: "21-30 hari",
                    description:
                        "Kabinet dapur lengkap dengan countertop, sink, dan storage. Desain modern dengan material tahan lama.",
                },
            ];
        },
        formatPrice(price) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(price);
        },
        formatPriceTag(category) {
            const labels = {
                low: "Budget",
                medium: "Standard",
                high: "Premium",
                premium: "Luxury",
            };
            return labels[category] || "";
        },
        resetFilters() {
            this.selectedCategory = "all";
            this.selectedMaterial = "all";
            this.selectedPriceRange = "all";
        },
        toggleFavorite(item) {
            const index = this.favorites.indexOf(item.id);
            if (index === -1) {
                this.favorites.push(item.id);
            } else {
                this.favorites.splice(index, 1);
            }
            // Simpan ke local storage
            localStorage.setItem(
                "furniture-favorites",
                JSON.stringify(this.favorites)
            );
        },
        viewDetails(item) {
            this.selectedFurniture = item;
            this.showModal = true;
        },
    },
};
</script>
