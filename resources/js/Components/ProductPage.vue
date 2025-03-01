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

            <div
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-10"
            >
                <div
                    class="border border-gray-100 p-1 rounded-lg"
                    v-for="(product, index) in Products"
                    :key="index"
                >
                    <!-- Gambar Produk -->
                    <img
                        class="w-full h-48 object-cover rounded-t-lg"
                        :src="helpers.imageUrl(product.image)"
                        :alt="product.name"
                    />

                    <!-- Detail Produk -->
                    <div
                        class="flex flex-col gap-2 text-[#2E2E2E] p-5 rounded-b-lg hover:shadow-lg bg-gray-50"
                    >
                        <Link :href="'/product/' + product.slug">
                            <h4 class="font-bold text-lg hover:underline">
                                {{ product.name }}
                            </h4>
                        </Link>

                        <!-- Harga & Kategori -->
                        <div
                            class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                        >
                            <b class="mt-2">
                                {{
                                    product.price == 0
                                        ? "Tanya Admin"
                                        : helpers.rupiah(product.price)
                                }}
                            </b>
                            <span class="mt-2 flex items-center gap-1">
                                <i class="mdi mdi-tag text-lg"></i>
                                {{ product.subcategory.name }}
                            </span>
                        </div>

                        <!-- Tombol WhatsApp & Tambah ke Keranjang -->
                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <!-- Tombol WhatsApp -->
                            <div
                                class="border border-spacing-1 rounded-md hover:bg-[#D4A373]"
                            >
                                <a
                                    :href="
                                        helpers.WaButton(
                                            Global,
                                            '/product/' + product.slug
                                        )
                                    "
                                    class="w-full py-3 rounded-full text-[#2E2E2E] font-bold text-center flex items-center justify-center gap-2 text-sm md:text-base"
                                >
                                    <i class="mdi mdi-whatsapp text-xl"></i>
                                </a>
                            </div>

                            <!-- Tombol Tambah ke Keranjang -->
                            <div
                                class="border border-spacing-1 rounded-md hover:bg-[#D4A373]"
                            >
                                <button
                                    @click="addToCart(product)"
                                    class="w-full p-3 rounded-full text-[#2E2E2E] font-bold text-center flex items-center justify-center gap-2 text-sm md:text-base"
                                    target="_blank"
                                >
                                    <i class="mdi mdi-cart-plus text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center" v-show="Filter == null">
                <Link
                    href="/products?filter=all"
                    class="bg-white border-2 p-2 rounded-full text-[#2E2E2E] hover:border-[#2E2E2E] mt-10"
                    ><i class="mdi mdi-view-list"></i> Tampilkan Semua</Link
                >
            </div>
        </section>
        <br /><br />
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount, watch, inject } from "vue";
const helpers = inject("helpers");

defineProps({
    Products: Object,
    HeadTitle: String,
    Action: String,
    Categories: Object,
    Filter: String,
    Global: Object,
    FilterQuery: String,
});
const cart = ref([]);
const addToCart = (product) => {
    const existingProduct = cart.value.find((item) => item.id === product.id);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.value.push({ ...product, quantity: 1 });
    }

    saveCart();
    alert("Produk ditambahkan ke keranjang!");
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
</script>
