<template>
    <div class="text-[#4A4A4A]">
        <section class="py-10 px-5 md:px-20 lg:px-64 text-[#2E2E2E]">
            <div
                class="flex flex-col md:flex-row justify-start mb-10 border-b-2 border-[#2E2E2E] md:w-4/12 md:text-sm"
            >
                <h2
                    class="text-secondary text-xl text-center md:text-left md:text-4xl mb-5 md:mb-0 poppins-bold uppercase"
                >
                    <i class="mdi mdi-sofa-single"></i> {{ HeadTitle }}
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
                        <i class="mdi mdi-view-list"></i> Semua Produk
                    </Link>
                    <Link
                        href="?filter=new"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-moon-new"></i> Terbaru
                    </Link>
                    <Link
                        href="?filter=populer"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-star-box"></i> Terpopuler
                    </Link>
                </div>
                <div class="flex justify-end">
                    <Link
                        v-show="Filter == 'desc_harga'"
                        href="?filter=asc_harga"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-sort-descending"></i> Harga
                    </Link>
                    <Link
                        v-show="Filter == 'asc_harga'"
                        href="?filter=desc_harga"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-sort-ascending"></i> Harga
                    </Link>
                    <Link
                        v-show="
                            Filter !== 'asc_harga' && Filter !== 'desc_harga'
                        "
                        href="?filter=desc_harga"
                        class="hover:bg-gray-100 text-[#2E2E2E] font-bold py-2 px-4 rounded-full"
                        preserve-scroll
                    >
                        <i class="mdi mdi-sort"></i> Harga
                    </Link>
                </div>
            </div>

            <div
                class="m-5 p-3 rounded text-[#2E2E2E] flex justify-between"
                v-show="Filter !== null"
            >
                <div v-if="Filter != 'search'">
                    <span class="font-thin underline">Filter </span> :
                    <span class="font-bold" v-if="Filter == 'all'"
                        >Semua Produk</span
                    >
                    <span class="font-bold" v-if="Filter == 'new'"
                        >Produk Terbaru</span
                    >
                    <span class="font-bold" v-if="Filter == 'populer'"
                        >Produk Terpopuler</span
                    >
                    <span class="font-bold" v-if="Filter == 'asc_harga'"
                        >Harga Termurah</span
                    >
                    <span class="font-bold" v-if="Filter == 'desc_harga'"
                        >Harga Termahal</span
                    >
                    <span class="font-bold" v-if="Filter == 'recommended'"
                        >Rekomendasi Produk</span
                    >
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
                    v-for="(product, index) in Products"
                    :key="index"
                >
                    <!-- Label HOT SALE -->

                    <div
                        v-if="product.recomended === 1"
                        class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full m-1"
                    >
                        🔥 hot sale
                    </div>

                    <!-- Gambar Produk -->
                    <img
                        class="w-full h-48 md:h-80 object-cover rounded-sm"
                        :src="helpers.imageUrl(product.image)"
                        :alt="product.name"
                    />

                    <!-- Detail Produk -->
                    <div class="flex flex-col gap-2">
                        <div
                            class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                        >
                            <Link :href="'/product/' + product.slug">
                                <h4
                                    class="font-normal text-lg hover:underline text-[#2E2E2E]"
                                >
                                    {{ product.name }}
                                </h4>
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
                        <button
                            @click="addToCart(product)"
                            class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline transition mdi mdi-cart-plus hover:bg-gray-100"
                        >
                            ADD TO CART
                        </button>
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
                    ><i class="mdi mdi-view-list"></i> Tampilkan Semua</Link
                >
            </div>
            <transition
                enter-active-class="transition-opacity duration-500"
                enter-from-class="opacity-0 translate-y-5"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-opacity duration-500"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-5"
            >
                <div
                    v-if="showOrderPopup"
                    class="fixed bottom-5 left-5 bg-white border border-gray-300 p-2 shadow-lg rounded-lg flex items-center gap-3 px-10"
                >
                    <img
                        class="w-12 h-12 object-cover rounded-sm"
                        :src="helpers.imageUrl(randomProduct.image)"
                        :alt="randomProduct.name"
                    />
                    <div>
                        <p class="text-sm font-bold">
                            {{ randomProduct.name }}
                        </p>
                        <p class="text-xs text-gray-500">Baru saja dibeli!</p>
                    </div>
                </div>
            </transition>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, inject } from "vue";
import { Link } from "@inertiajs/vue3";

const helpers = inject("helpers");

const props = defineProps({
    Products: Object,
    HeadTitle: String,
    Action: String,
    Categories: Object,
    Filter: String,
    Global: Object,
    FilterQuery: String,
});

const cart = ref([]);
const showNotification = ref(false);
const notificationMessage = ref("");
const showOrderPopup = ref(null);
const randomProduct = ref({});
const startOrderPopup = () => {
    const showRandomPopup = () => {
        if (props.Products.length > 0) {
            const randomIndex = Math.floor(
                Math.random() * props.Products.length
            );
            randomProduct.value = props.Products[randomIndex]; // Pilih produk acak
            showOrderPopup.value = true;

            setTimeout(() => {
                showOrderPopup.value = false;
            }, 3000);
        }

        // Atur waktu acak antara 1 - 12 jam (dalam milidetik)
        const randomTime =
            Math.floor(Math.random() * (12 - 1 + 1) + 1) * 60 * 60 * 1000;

        setTimeout(showRandomPopup, randomTime); // Panggil ulang dengan waktu acak
    };

    showRandomPopup(); // Jalankan pertama kali
};
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
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
    startOrderPopup();
});

watch(cart, saveCart, { deep: true });
</script>
