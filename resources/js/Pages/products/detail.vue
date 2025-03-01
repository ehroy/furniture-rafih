<template>
    <div>
        <JustHead :Global="Global" :title="product.name" />
        <Navbar :Categories="Categories" />

        <div class="container mx-auto mt-10">
            <br />
            <div class="border-b-2 border-black mt-12">
                <nav class="flex items-center space-x-2 text-gray-700 py-4">
                    <Link href="/" class="hover:text-gray-900"
                        ><i class="mdi mdi-home"></i> Home</Link
                    >
                    <span>></span>
                    <Link
                        :href="'/category/' + Category?.id"
                        class="hover:text-gray-900"
                        ><i class="mdi mdi-tag"></i> {{ Category?.name }}</Link
                    >
                    <span>></span>
                    <span class="text-gray-500">{{
                        product?.subcategory?.name
                    }}</span>
                </nav>
            </div>
            <div class="flex flex-col md:flex-row mt-10">
                <div class="md:w-1/2">
                    <div class="p-5">
                        <img
                            :src="helpers.imageUrl(product.image)"
                            :alt="product.name"
                            class="w-full rounded-lg transition-transform duration-500 ease-in-out transform hover:scale-105 hover:cursor-zoom-in"
                        />
                        <br />
                        <hr />
                        <div class="hidden md:block">
                            <h3 class="text-2xl poppins-bold mt-5 mb-3">
                                <i class="mdi mdi-table-furniture"></i> Produk
                                Serupa
                            </h3>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-10 mt-5"
                            >
                                <div
                                    class="rounded-lg"
                                    v-for="(relatedProduct, index) in Products"
                                    :key="index"
                                >
                                    <img
                                        class="w-full rounded-t-lg"
                                        :src="
                                            helpers.imageUrl(
                                                relatedProduct.image
                                            )
                                        "
                                        :alt="relatedProduct.name"
                                    />
                                    <div
                                        class="flex flex-col gap-2 text-gray-600 bg-[#FFCC4C] p-5 rounded-b-lg hover:shadow-lg"
                                    >
                                        <Link
                                            :href="
                                                '/product/' +
                                                relatedProduct.slug
                                            "
                                        >
                                            <h4
                                                class="font-bold hover:underline"
                                            >
                                                {{ relatedProduct.name }}
                                            </h4>
                                        </Link>

                                        <div
                                            class="flex flex-col md:flex-row md:justify-between"
                                        >
                                            <b class="text-sm mt-2">{{
                                                relatedProduct.price == 0
                                                    ? "Tanya Admin"
                                                    : helpers.rupiah(
                                                          relatedProduct.price
                                                      )
                                            }}</b>
                                            <span class="text-sm mt-2"
                                                ><i class="mdi mdi-tag"></i>
                                                {{
                                                    relatedProduct.subcategory
                                                        .name
                                                }}</span
                                            >
                                        </div>
                                        <a
                                            class="bg-amber-500 px-8 py-2 rounded-lg text-white font-bold text-center hover:bg-amber-700 uppercase"
                                            :href="
                                                helpers.WaButton(
                                                    Global,
                                                    '/product/' +
                                                        relatedProduct.slug
                                                )
                                            "
                                            ><i class="mdi mdi-whatsapp"></i>
                                            {{
                                                Global.Settings
                                                    .action_button_text
                                            }}</a
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 px-10 py-10">
                    <h1
                        class="text-3xl font-bold text-center md:text-left mb-4 poppins-bold"
                    >
                        <i class="mdi mdi-cart-heart"></i> {{ product.name }}
                    </h1>
                    <div
                        class="flex flex-col md:flex-row justify-between items-center mt-4"
                    >
                        <span
                            class="text-sm md:text-xl font-semibold border-2 p-2 rounded-full border-amber-400 mb-2"
                            >{{
                                product.price == 0
                                    ? "Tanya Admin"
                                    : helpers.rupiah(product.price)
                            }}</span
                        >
                        <span
                            class="text-md text-gray-500 border-2 p-2 rounded-full border-amber-400 mb-2"
                            ><i class="mdi mdi-tag"></i>
                            {{ product.subcategory.name }}</span
                        >
                        <span
                            class="text-sm text-gray-500 border-2 p-2 rounded-full border-amber-400 mb-2"
                            ><i class="mdi mdi-eye-outline"></i>
                            {{ product.views }}x dilihat</span
                        >
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 font-bold mb-2"
                            >Pilih Warna:</label
                        >
                        <div class="flex space-x-2">
                            <button
                                v-for="(color, index) in dummyColors"
                                :key="index"
                                :class="[
                                    'w-8 h-8 rounded-full border-2',
                                    color,
                                    selectedColor === color
                                        ? 'border-black'
                                        : '',
                                ]"
                                @click="selectColor(color)"
                            ></button>
                        </div>
                    </div>
                    <a
                        class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-full block w-full mt-4 uppercase text-center"
                        :href="
                            helpers.WaButton(Global, '/product/' + product.slug)
                        "
                        target="_blank"
                    >
                        <i class="mdi mdi-whatsapp"></i>
                        {{ Global.Settings.action_button_text }}
                    </a>
                    <button
                        v-if="product.price > 0"
                        @click="addToCart(product)"
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full block w-full mt-4 uppercase text-center"
                    >
                        <i class="mdi mdi-cart"></i> Tambahkan ke Keranjang
                    </button>
                    <div
                        class="text-gray-600 text-center md:text-left px-4 mt-5"
                    >
                        <button
                            @click="showContent = !showContent"
                            class="bg-amber-500 text-white px-4 py-2 rounded-lg font-semibold"
                        >
                            {{ showContent ? "Sembunyikan" : "Tampilkan" }}
                            Deskripsi
                        </button>
                        <div
                            v-show="showContent"
                            class="prose lg:prose-xl mt-3"
                            v-html="product.content"
                        ></div>
                    </div>
                    <div class="block md:hidden">
                        <h3 class="text-2xl poppins-bold mt-5 mb-3">
                            <i class="mdi mdi-table-furniture"></i> Produk
                            Serupa
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-10 mt-5"
                        >
                            <div
                                class="rounded-lg"
                                v-for="(product, index) in Products"
                                :key="index"
                            >
                                <img
                                    class="w-full rounded-t-lg"
                                    :src="helpers.imageUrl(product.image)"
                                    :alt="product.name"
                                />
                                <div
                                    class="flex flex-col gap-2 text-gray-600 bg-[#FFCC4C] p-5 rounded-b-lg hover:shadow-lg"
                                >
                                    <Link :href="'/product/' + product.slug">
                                        <h4 class="font-bold hover:underline">
                                            {{ product.name }}
                                        </h4>
                                    </Link>

                                    <div
                                        class="flex flex-col md:flex-row md:justify-between"
                                    >
                                        <b class="text-sm mt-2">{{
                                            product.price == 0
                                                ? "Tanya Admin"
                                                : helpers.rupiah(product.price)
                                        }}</b>
                                        <span class="text-sm mt-2"
                                            ><i class="mdi mdi-tag"></i>
                                            {{ product.subcategory.name }}</span
                                        >
                                    </div>
                                    <a
                                        class="bg-amber-500 px-8 py-2 rounded-lg text-white font-bold text-center hover:bg-amber-700 uppercase"
                                        :href="
                                            helpers.WaButton(
                                                Global,
                                                '/product/' + product.slug
                                            )
                                        "
                                        ><i class="mdi mdi-whatsapp"></i>
                                        {{
                                            Global.Settings.action_button_text
                                        }}</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from "../../Components/Navbar.vue";
import { Link } from "@inertiajs/vue3";
import { inject, ref } from "vue";
import JustHead from "../../Components/JustHead.vue";
const showContent = ref(false);
const helpers = inject("helpers");
const cart = ref(JSON.parse(localStorage.getItem("cart")) || []);
const selectedColor = ref(null);
defineProps({
    product: Object,
    Products: Object,
    Category: Object,
    Categories: Object,
    Global: Object,
});
const dummyColors = ref([
    "bg-red-500",
    "bg-blue-500",
    "bg-green-500",
    "bg-yellow-500",
    "bg-purple-500",
]);
const selectColor = (color) => {
    selectedColor.value = color;
    console.log("Warna dipilih:", selectedColor.value);
};

const addToCart = (product) => {
    console.log(selectedColor);
    if (!selectedColor.value) {
        alert("Silakan pilih warna terlebih dahulu!");
        return;
    }
    cart.value.push({ ...product, selectedColor: dummyColors.value });
    localStorage.setItem("cart", JSON.stringify(cart.value));
    alert(
        `Produk ${product.name} dengan warna ${selectedColor.value} telah ditambahkan ke keranjang!`
    );
};
</script>
