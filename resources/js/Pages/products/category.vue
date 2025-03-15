<template>
    <div>
        <JustHead :Global="Global" :title="'Kategori ' + Category.name" />
        <Navbar :Categories="Categories" />
        <br /><br />

        <div class="container mx-auto py-5 px-5 md:py-20 md:px-20">
            <div class="border-b-2 border-black mt-12">
                <nav class="flex items-center space-x-2 text-gray-700 py-4">
                    <Link href="/" class="hover:text-gray-900"
                        ><i class="mdi mdi-home"></i> Home</Link
                    >
                    <span>></span>
                    <Link
                        :href="'/category/' + Category.id"
                        class="hover:text-gray-900"
                        ><i class="mdi mdi-tag"></i> {{ Category.name }}</Link
                    >
                    <span>></span>
                    <span class="text-gray-500">{{
                        subCategory?.name ?? "All"
                    }}</span>
                </nav>
            </div>
            <div class="border-b-2 border-gray-700 w-3/12 mt-10">
                <h1 class="mt-5 mb-10 text-3xl poppins-bold uppercase">
                    <i class="mdi mdi-tag"></i> {{ Category.name }}
                </h1>
            </div>
            <div
                class="flex justify-center items-center text-sm font-medium text-center text-gray-500 dark:text-gray-400 dark:border-gray-700 mt-10"
            >
                <br /><br />

                <ul class="flex flex-wrap -mb-px border-b-2 border-gray-300">
                    <li
                        class="me-2"
                        v-for="(cat, index) in SubCategories"
                        :key="index"
                    >
                        <Link
                            :href="'?sub=' + cat.id"
                            :class="
                                ActiveCat == cat.id
                                    ? 'inline-block p-4 border-2 border-transparent   bg-[#2d2d2d] text-gray-50'
                                    : 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'
                            "
                            preserve-scroll
                            >{{ cat.name }}</Link
                        >
                    </li>
                </ul>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1">
                <div
                    class="hover:border border-gray-300 p-2 rounded-sm"
                    v-for="(product, index) in Products.filter(
                        (product) => product.variants.length > 0
                    )"
                    :key="index"
                >
                    <!-- Gambar Produk -->
                    <img
                        class="w-full h-48 md:h-80 object-cover rounded-sm"
                        :src="helpers.imageUrl(product.image)"
                        :alt="product.name"
                    />

                    <!-- Detail Produk -->
                    <div
                        class="flex flex-col gap-2 text-[#2E2E2E] p-2 rounded-b-lg"
                    >
                        <!-- Harga & Kategori -->
                        <div
                            class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                        >
                            <Link :href="'/product/' + product.slug">
                                <h4 class="font-normal text-lg hover:underline">
                                    {{ product.name }}
                                </h4>
                            </Link>
                            <!-- <span class="mt-2 flex items-center gap-1">
                                <i class="mdi mdi-tag text-lg"></i>
                                {{ product.subcategory.name }}
                            </span> -->
                        </div>
                        <div class="flex flex-col-reverse">
                            <div class="flex justify-start gap-2">
                                <i
                                    class="mdi mdi-star text-xl text-yellow-300"
                                ></i>
                                <i
                                    class="mdi mdi-star text-xl text-yellow-300"
                                ></i>
                                <i
                                    class="mdi mdi-star text-xl text-yellow-300"
                                ></i>
                                <i
                                    class="mdi mdi-star text-xl text-yellow-300"
                                ></i>
                                <i
                                    class="mdi mdi-star text-xl text-gray-300"
                                ></i>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-center gap-2 md:gap-4 text-white w-full mb-4 mt-12"
                        >
                            <!-- ADD TO CART -->

                            <template v-if="product.variants.length > 0">
                                <!-- Jika produk memiliki lebih dari 1 variant, gunakan Link ke halaman detail -->
                                <Link
                                    :href="'/product/' + product.slug"
                                    class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline hover:text-[#2E2E2E] transition mdi mdi-cart-plus hover:bg-gray-100"
                                >
                                    DETAILS
                                </Link>
                            </template>
                            <template v-else>
                                <!-- Jika hanya 1 variant, tetap gunakan button untuk addToCart -->
                                <button
                                    @click="addToCart(product)"
                                    class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline hover:text-[#2E2E2E] transition mdi mdi-cart-plus hover:bg-gray-100"
                                >
                                    ADD TO CART
                                </button>
                            </template>
                        </div>
                        <!-- ADD NOTIFKASI MESSAGE -->
                        <transition
                            enter-active-class="transform transition duration-500 ease-out"
                            enter-from-class="translate-y-10 opacity-0"
                            enter-to-class="translate-y-0 opacity-100"
                            leave-active-class="transform transition duration-500 ease-in"
                            leave-from-class="translate-y-0 opacity-100"
                            leave-to-class="translate-y-10 opacity-0"
                        >
                            <div
                                v-if="showNotification"
                                class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-green-400 text-white px-6 py-3 rounded-lg flex items-center gap-3"
                            >
                                <i class="mdi mdi-check-circle text-xl"></i>
                                <span class="text-sm font-semibold">{{
                                    notificationMessage
                                }}</span>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
    <Popup :Global="Global" :Products="Products" />
</template>

<script setup>
import Popup from "../../Components/Popup.vue";
import Navbar from "../../Components/Navbar.vue";
import Footer from "../../Components/Footer.vue";
import { ref, onMounted, watch, inject } from "vue";
import { Link } from "@inertiajs/vue3";
import JustHead from "../../Components/JustHead.vue";

const props = defineProps({
    Products: Object,
    Categories: Object,
    SubCategories: Object,
    Filter: String,
    ActiveCat: String,
    Category: Object,
    subCategory: Object,
    Global: Object,
    Socmed: Object,
    Pages: Object,
});
console.log(props.Categories);
const cart = ref([]);
const showNotification = ref(false);
const notificationMessage = ref("");

const addToCart = (product) => {
    const existingProduct = cart.value.find((item) => item.id === product.id);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }

    saveCart();

    // Set pesan notifikasi
    notificationMessage.value = `${product.name} ditambahkan ke keranjang!`;
    showNotification.value = true;

    // Sembunyikan notifikasi setelah 3 detik
    setTimeout(() => {
        showNotification.value = false;
    }, 3000);
};

// Simpan ke localStorage setiap ada perubahan pada `cart`
const saveCart = () => {
    localStorage.setItem("cart", JSON.stringify(cart.value));
};

// Ambil data dari localStorage saat halaman dimuat
onMounted(() => {
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
});

// Pantau perubahan `cart` dan simpan otomatis
watch(cart, saveCart, { deep: true });
const Action = "kategori";
const helpers = inject("helpers");
</script>
