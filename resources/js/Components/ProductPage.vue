<template>
    <div class="text-[#4A4A4A]">
        <section class="py-24 px-5 md:px-20 lg:px-64 text-[#2E2E2E]">
            <div
                class="flex flex-col md:flex-row justify-start mb-10 border-b-2 border-[#2E2E2E] md:w-4/12 md:text-sm"
            >
                <h2
                    class="text-secondary text-xl text-center md:text-left md:text-4xl mb-5 md:mb-0 poppins-bold uppercase"
                >
                    <i class="mdi mdi-sofa-single"></i> {{ $t("product.kami") }}
                </h2>
            </div>
            <div
                class="md:flex-row justify-between mb-10 mt-5 grid grid-cols-2"
            >
                <div class="flex flex-wrap gap-1 justify-start">
                    <Link
                        href="?filter=all"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-view-list"></i>
                        {{ $t("product.all") }}
                    </Link>
                    <Link
                        href="?filter=new"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-moon-new"></i>{{ $t("product.new") }}
                    </Link>
                    <Link
                        href="?filter=populer"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-star-box"></i>
                        {{ $t("product.populer") }}
                    </Link>
                </div>

                <div class="flex justify-end relative" @click="toggleDropdown">
                    <button class="flex flex-col items-center hover:text-black">
                        <span
                            class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                            >Category</span
                        >
                    </button>
                    <div
                        v-if="isOpen"
                        class="absolute top-12 w-40 bg-white rounded-lg shadow-md z-50"
                    >
                        <ul class="flex flex-col p-3">
                            <li
                                v-for="(cat, index) in Categories"
                                :key="index"
                                class="py-1"
                            >
                                <Link
                                    :href="'?filter=' + cat.slug"
                                    class="text-black hover:text-[#212121]"
                                >
                                    {{ cat.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div
                class="m-5 p-3 rounded text-[#2E2E2E] flex justify-between"
                v-show="Filter !== null"
            >
                <div v-if="Filter != 'search'">
                    <span class="font-thin underline">Filter </span> :
                    <span class="font-bold" v-if="Filter == 'all'">{{
                        $t("product.all")
                    }}</span>
                    <span class="font-bold" v-if="Filter == 'new'"
                        >Product {{ $t("product.new") }}</span
                    >
                    <span class="font-bold" v-if="Filter == 'populer'"
                        >Product {{ $t("product.populer") }}</span
                    >
                    <span class="font-bold" v-if="Filter == 'asc_harga'">
                        {{ $t("product.murah") }}</span
                    >
                    <span class="font-bold" v-if="Filter == 'desc_harga'">
                        {{ $t("product.mahal") }}</span
                    >
                    <span class="font-bold" v-if="Filter == 'recommended'">{{
                        $t("product.rekomendasi")
                    }}</span>
                </div>
                <div v-else>
                    <span class="font-thin underline">Search </span> :
                    <span class="font-bold">{{ FilterQuery }}</span>
                </div>
                <div class="hover:font-bold">
                    <Link href="?filter" preserve-scroll
                        ><i class="mdi mdi-close"></i> Reset</Link
                    >
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1">
                <div
                    class="hover:border border-gray-300 p-2 text-white hover:text-[#2E2E2E] relative"
                    v-for="(product, index) in Products.filter(
                        (product) =>
                            product.variants.length > 0 &&
                            product.image &&
                            product.image.length > 0
                    )"
                    :key="index"
                >
                    <!-- Label HOT SALE -->

                    <div
                        v-if="product.recomended === 1"
                        class="absolute top-2 left-2 bg-red-700 text-white text-xs font-bold px-2 py-1 rounded-full m-1"
                    >
                        🔥 hot sale
                    </div>

                    <!-- Gambar Produk -->
                    <img
                        class="w-full h-48 md:h-80 object-cover rounded-sm"
                        :src="helpers.imageUrl(product.image[0])"
                        :alt="product.name"
                        type="image/webp"
                        loading="lazy"
                    />

                    <!-- Detail Produk -->
                    <div class="flex flex-col gap-2">
                        <div
                            class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                        >
                            <Link :href="'/product/' + product.slug">
                                <h1
                                    class="font-normal text-lg hover:underline text-[#2E2E2E]"
                                >
                                    {{ product.name }}
                                </h1>
                            </Link>
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
                        <template v-if="product.variants.length > 0">
                            <!-- Jika produk memiliki lebih dari 1 variant, gunakan Link ke halaman detail -->
                            <Link
                                :href="'/product/' + product.slug"
                                class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline transition mdi mdi-cart-plus hover:bg-gray-100"
                            >
                                DETAILS
                            </Link>
                        </template>
                        <template v-else>
                            <!-- Jika hanya 1 variant, tetap gunakan button untuk addToCart -->
                            <button
                                @click="addToCart(product)"
                                class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline transition mdi mdi-cart-plus hover:bg-gray-100"
                            >
                                ADD TO CART
                            </button>
                        </template>

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
            <div class="flex justify-center mt-2" v-show="Filter == null">
                <Link
                    href="/products?filter=all"
                    class="bg-white border-2 p-2 rounded-full text-[#2E2E2E] hover:border-[#2E2E2E]"
                    ><i class="mdi mdi-view-list"></i> {{ $t("all") }}</Link
                >
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, inject, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";

const helpers = inject("helpers");
const isOpen = ref(false);
const props = defineProps({
    Products: Object,
    HeadTitle: String,
    Filter: String,
    Global: Object,
    FilterQuery: String,
    ActiveCat: String,
    Categories: Object,
    SubCategories: Object,
});
console.log(props.Products);
const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    console.log(isOpen.value);
};
const closeDropdown = (event) => {
    if (!event.target.closest(".relative")) {
        isOpen.value = false;
    }
};

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
    notificationMessage.value = `${product.name} ditambahkan ke keranjang!`;
    showNotification.value = true;
    setTimeout(() => {
        showNotification.value = false;
    }, 3000);
};

const saveCart = () => {
    localStorage.setItem("cart", JSON.stringify(cart.value));
};

onMounted(() => {
    window.addEventListener("click", closeDropdown);
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
});
onBeforeUnmount(() => {
    window.removeEventListener("click", closeDropdown);
});
watch(cart, saveCart, { deep: true });
</script>
