<template>
    <div>
        <JustHead :Global="Global" :title="product.name" />
        <Navbar :Categories="Categories" />
        <div class="container mx-auto mt-10">
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
                    class="fixed top-[10%] left-1/2 -translate-x-1/2 bg-green-400 text-white px-6 py-3 rounded-lg flex items-center gap-3 z-[999]"
                >
                    <i class="mdi mdi-check-circle text-xl"></i>
                    <span class="text-sm font-semibold">{{
                        notificationMessage
                    }}</span>
                </div>
            </transition>
            <br />
            <transition
                enter-active-class="transform transition duration-500 ease-out"
                enter-from-class="translate-y-10 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transform transition duration-500 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="translate-y-10 opacity-0"
            >
                <div
                    v-if="showNotificationalert"
                    class="fixed top-[10%] left-1/2 -translate-x-1/2 bg-red-400 text-white px-6 py-3 rounded-lg flex items-center gap-3 z-[999]"
                >
                    <i class="mdi mdi-check-circle text-xl"></i>
                    <span class="text-sm font-semibold">{{
                        notificationMessage
                    }}</span>
                </div>
            </transition>
            <br />
            <div class="border-b-2 border-black mt-12 m-5">
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
                        <div class="flex flex-col md:flex-row items-center">
                            <img
                                :src="
                                    helpers.imageUrl(
                                        images[activeIndex].images[0].image
                                    )
                                "
                                :alt="images[activeIndex].name"
                                class="w-full h-64 object-cover rounded-lg"
                            />
                            <div
                                class="absolute inset-0 flex justify-between items-center p-2"
                            >
                                <button
                                    @click="prevImage"
                                    class="bg-white p-1 rounded-full shadow"
                                >
                                    ‹
                                </button>
                                <button
                                    @click="nextImage"
                                    class="bg-white p-1 rounded-full shadow"
                                >
                                    ›
                                </button>
                            </div>

                            <br />
                            <hr />
                        </div>

                        <div class="hidden md:block text-[#2E2E2E]">
                            <h3 class="text-2xl poppins-bold mt-5 mb-3">
                                <i class="mdi mdi-table-furniture"></i>
                                {{ $t("product_serupa") }}
                            </h3>
                            <div class="grid grid-cols-2 gap-1">
                                <div
                                    class="hover:border border-gray-300 p-2 text-white hover:text-[#2E2E2E]"
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
                                    <div class="flex flex-col gap-2">
                                        <!-- Harga & Kategori -->
                                        <div
                                            class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                                        >
                                            <Link
                                                :href="
                                                    '/product/' + product.slug
                                                "
                                            >
                                                <h4
                                                    class="font-normal text-lg hover:underline text-[#2E2E2E]"
                                                >
                                                    {{ product.name }}
                                                </h4>
                                            </Link>
                                        </div>
                                        <div class="flex flex-col-reverse">
                                            <div
                                                class="flex justify-start gap-2"
                                            >
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
                                        <template
                                            v-if="product.variants.length > 1"
                                        >
                                            <!-- Jika produk memiliki lebih dari 1 variant, gunakan Link ke halaman detail -->
                                            <Link
                                                :href="
                                                    '/product/' + product.slug
                                                "
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
                    <div class="flex flex-col-reverse">
                        <div class="flex justify-start gap-2 text-center">
                            <i class="mdi mdi-star text-xl text-yellow-300"></i>
                            <i class="mdi mdi-star text-xl text-yellow-300"></i>
                            <i class="mdi mdi-star text-xl text-yellow-300"></i>
                            <i class="mdi mdi-star text-xl text-yellow-300"></i>
                            <i class="mdi mdi-star text-xl text-gray-300"></i>
                            <p class="font-bold">(89)</p>
                        </div>
                    </div>
                    <div v-if="product.variants" class="mt-4">
                        <!-- PILIH WARNA -->
                        <label class="block text-gray-700 font-bold mb-2"
                            >colors :
                        </label>
                        <div class="flex space-x-2">
                            <button
                                v-for="(group, index) in uniqueColors"
                                :key="index"
                                class="w-8 h-8 rounded-full border-2 hover:border-gray-500 transition duration-200"
                                :class="[
                                    selectedColor === group.color.name
                                        ? 'border-black'
                                        : 'border-gray-300',
                                ]"
                                :style="{
                                    backgroundColor: extractColor(
                                        group.color.image[0]
                                    ),
                                }"
                                @click="selectColor(group.color.name)"
                            >
                                <img
                                    :src="
                                        helpers.imageUrl(group.color.image[0])
                                    "
                                    class="w-full h-full object-cover rounded-full"
                                />

                                <span
                                    v-if="selectedColor === group.color.name"
                                    class="text-xs font-semibold"
                                >
                                    {{ group.color.name }}
                                </span>
                            </button>
                        </div>

                        <!-- PILIH KAYU -->
                        <div v-if="selectedColor" class="mt-6">
                            <label class="block text-gray-700 font-bold mb-2"
                                >wood :
                            </label>
                            <div class="flex space-x-2 w-full overflow-auto">
                                <button
                                    v-for="(wood, index) in uniqueColors.find(
                                        (c) => c.color.name === selectedColor
                                    )?.woods"
                                    :key="index"
                                    class="px-4 py-2 border rounded"
                                    @click="selectedWood = wood.name"
                                    :class="
                                        selectedWood === wood.name
                                            ? 'bg-gray-300 '
                                            : ''
                                    "
                                >
                                    {{ wood.name }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="flex items-center mb-6 mt-6 gap-2">
                        <button
                            class="w-10 h-10 border border-gray-300 rounded-l flex items-center justify-center hover:bg-gray-100"
                            @click="decrementQuantity"
                        >
                            <span class="text-xl">−</span>
                        </button>
                        <input
                            type="text"
                            v-model="quantity"
                            class="w-12 h-10 border-t border-b border-gray-300 text-center outline-none"
                        />
                        <button
                            class="w-10 h-10 border border-gray-300 rounded-r flex items-center justify-center hover:bg-gray-100"
                            @click="incrementQuantity"
                        >
                            <span class="text-xl">+</span>
                        </button>
                        <button
                            @click="addToCart(product)"
                            class="w-full bg-black text-white font-medium py-3 hover:bg-gray-800 transition-colors"
                        >
                            ADD TO CART
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <a
                            class="w-full bg-gray-800 text-white font-medium py-3 rounded hover:bg-gray-700 transition-colors uppercase text-center block"
                            :href="
                                helpers.WaButton(
                                    Global,
                                    '/product/' + product.slug
                                )
                            "
                            target="_blank"
                        >
                            <i class="mdi mdi-whatsapp"></i>
                            {{ Global.Settings.action_button_text }}
                        </a>

                        <!-- Additional Options -->
                        <div class="flex flex-row gap-4 mt-4 text-center">
                            <span class="text-sm text-gray-500 b p-2 mb-2"
                                ><i class="mdi mdi-eye-outline p-2"></i>

                                <strong>
                                    {{ product.views }} x views
                                </strong></span
                            >
                            <span
                                class="flex flex-row text-center text-sm text-gray-500 p-2 mb-2"
                                ><svg
                                    class="base-svg-icon base-checkbox-alt-svg"
                                    fill="currentColor"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 16 16"
                                >
                                    <title>Check Mark</title>
                                    <path
                                        d="M13.739 3.061l-5.5-3c-0.075-0.041-0.157-0.061-0.239-0.061s-0.165 0.020-0.239 0.061l-5.5 3c-0.161 0.088-0.261 0.256-0.261 0.439v4c0 2.2 0.567 3.978 1.735 5.437 0.912 1.14 2.159 2.068 4.042 3.010 0.070 0.035 0.147 0.053 0.224 0.053s0.153-0.018 0.224-0.053c1.883-0.942 3.13-1.87 4.042-3.010 1.167-1.459 1.735-3.238 1.735-5.437l0-4c0-0.183-0.1-0.351-0.261-0.439zM6.5 11.296l-2.796-2.796 0.796-0.795 2 2 5-5 0.796 0.795-5.795 5.795z"
                                    ></path>
                                    p
                                </svg>
                                Estimated Delivery : Up to 7-21 business days
                            </span>
                        </div>
                    </div>
                    <div class="p-2 border border-spacing-1 text-justify">
                        <div class="border-b">
                            <nav class="flex space-x-4" aria-label="Tabs">
                                <button
                                    v-for="(tab, index) in tabs"
                                    :key="index"
                                    @click="activeTab = index"
                                    :class="[
                                        activeTab === index
                                            ? 'border-b-2 border-black'
                                            : '',
                                        'px-4 py-2 text-gray-600 hover:text-black',
                                    ]"
                                >
                                    {{ tab.name }}
                                </button>
                            </nav>
                        </div>
                        <div class="p-4">
                            <div v-if="activeTab === 0">
                                <div v-html="product.content"></div>
                            </div>
                            <div v-if="activeTab === 1">
                                <h1>
                                    w : {{ product.width }} x d :
                                    {{ product.depth }} x h :
                                    {{ product.height }}
                                </h1>
                            </div>
                            <!-- <div v-if="activeTab === 1">
                                Additional information content...
                            </div>
                            <div v-if="activeTab === 2">Reviews content...</div>
                            <div v-if="activeTab === 3">
                                Shipping & Return content...
                            </div> -->
                        </div>
                    </div>

                    <!-- Trust Badges Section -->

                    <div class="block md:hidden">
                        <h3 class="text-2xl poppins-bold mt-5 mb-3">
                            <i class="mdi mdi-table-furniture"></i
                            >{{ $t("product_serupa") }}
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-10 mt-5 mx-10 text-center"
                        >
                            <div
                                class="rounded-lg hover:border p-2"
                                v-for="(product, index) in Products.filter(
                                    (product) => product.variants.length > 0
                                )"
                                :key="index"
                            >
                                <img
                                    class="w-full rounded-t-lg"
                                    :src="helpers.imageUrl(product.image)"
                                    :alt="product.name"
                                />
                                <div
                                    class="flex flex-col md:flex-row md:justify-between items-center text-sm"
                                >
                                    <Link :href="'/product/' + product.slug">
                                        <h4
                                            class="font-normal text-lg hover:underline"
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
                                <template v-if="product.variants.length > 1">
                                    <!-- Jika produk memiliki lebih dari 1 variant, gunakan Link ke halaman detail -->
                                    <div class="m-4 p-4 hover:bg-gray-100">
                                        <Link
                                            :href="'/product/' + product.slug"
                                            class="flex-1 p-2 md:p-3 text-center md:text-base font-semiboldhover:underline transition mdi mdi-cart-plus"
                                        >
                                            DETAILS
                                        </Link>
                                    </div>
                                </template>
                                <template v-else>
                                    <!-- Jika hanya 1 variant, tetap gunakan button untuk addToCart -->
                                    <div class="m-4 p-4 hover:bg-gray-100">
                                        <button
                                            @click="addToCart(product)"
                                            class="flex-1 p-2 md:p-3 text-center text-xs md:text-base font-semiboldhover:underline transition mdi mdi-cart-plus hover:bg-gray-100"
                                        >
                                            ADD TO CART
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer :Global="Global" :Socmed="Socmed" />
    <Popup :Global="Global" :Products="Products" />
</template>

<script setup>
import Popup from "../../Components/Popup.vue";
import Navbar from "../../Components/Navbar.vue";
import { Link } from "@inertiajs/vue3";
import { inject, ref, computed, onMounted } from "vue";
import Footer from "../../Components/Footer.vue";
import JustHead from "../../Components/JustHead.vue";
import { useI18n } from "vue-i18n";

const { locale } = useI18n();
// State
const showContent = ref(false);
const helpers = inject("helpers");
const cart = ref([]);
const selectedColor = ref(null);
const selectedWood = ref(null);
const quantity = ref(1);
const showNotification = ref(false);
const showNotificationalert = ref(false);

const notificationMessage = ref(null);
const extractColor = (color) => {
    if (!color) return "#FFFFFF"; // Default warna jika kosong
    const hexMatch = color.match(/#([0-9A-Fa-f]{6})/); // Cari warna HEX dalam string
    return hexMatch ? `#${hexMatch[1]}` : color; // Jika ada HEX, ambil HEX, jika tidak, gunakan as-is
};
// Props
const props = defineProps({
    product: Object,
    Products: Object,
    Category: Object,
    Categories: Object,
    Global: Object,
    Socmed: Object,
    Pages: Object,
});

// Ambil `cart` dari localStorage saat komponen dimuat
onMounted(() => {
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
});

// Tabs Data
const tabs = ref([{ name: "Description" }, { name: "Dimension" }]);
const activeTab = ref(0);

// Fungsi Menambah dan Mengurangi Kuantitas
const incrementQuantity = () => quantity.value++;
const decrementQuantity = () => {
    if (quantity.value > 1) quantity.value--;
};

// Fungsi Memilih Warna
const selectColor = (color) => {
    selectedColor.value = color;

    // Pilih kayu pertama yang tersedia untuk warna ini (jika ada)
    const availableWood = uniqueColors.value.find(
        (item) => item.color.name === color
    );
    selectedWood.value = availableWood?.woods?.[0]?.name || null;
};

// Fungsi Memilih Kayu
const selectWood = (wood) => {
    selectedWood.value = wood;
};
const selectedImage = ref(""); // Menyimpan gambar yang dipilih

// Ambil gambar default pertama
const setDefaultImage = () => {
    if (props.Products[0]?.image) {
        selectedImage.value = props.Products[0].image;
    }
};
const Dataimage = () => {
    const groupedImages = {};

    // Ambil default image dulu
    if (props.Products[0]?.image) {
        if (!groupedImages["default"]) {
            groupedImages["default"] = [];
        }
        groupedImages["default"].push({
            image: props.Products[0].image,
        });
    }

    // Lalu ambil variant images
    props.Products[0]?.variants.forEach((variant) => {
        if (variant.color?.name && variant.color?.image?.length) {
            variant.color.image.forEach((img) => {
                // Kelompokkan gambar berdasarkan nama warna
                const colorName = variant.color.name;
                if (!groupedImages[colorName]) {
                    groupedImages[colorName] = [];
                }
                groupedImages[colorName].push({
                    image: img, // Pastikan img adalah URL gambar atau objek dengan properti image
                });
            });
        }
    });

    // Transform objek groupedImages menjadi array
    const images = Object.keys(groupedImages).map((name) => ({
        name: name,
        images: groupedImages[name], // Array gambar untuk setiap nama
    }));

    return images;
};

const images = Dataimage();

const activeIndex = ref(0);

function nextImage() {
    activeIndex.value = (activeIndex.value + 1) % images.length;
}

function prevImage() {
    activeIndex.value = (activeIndex.value - 1 + images.length) % images.length;
}
// Fungsi Menambahkan ke Keranjang
const addToCart = (product) => {
    if (!selectedColor.value || !selectedWood.value) {
        alert("Silakan pilih warna dan jenis kayu terlebih dahulu!");
        return;
    }

    const selectedVariant = product.variants?.find(
        (variant) =>
            variant.color?.name === selectedColor.value &&
            variant.wood?.name === selectedWood.value
    );

    if (!selectedVariant) {
        showNotificationalert.value = true;
        notificationMessage.value = `select the variant first`;
        setTimeout(() => {
            showNotificationalert.value = false;
        }, 3000);
        return;
    }
    // if (selectedVariant.stock <= 0) {
    //     showNotificationalert.value = true;
    //     notificationMessage.value = `Oops! This variant is not available right now. Feel free to contact us on WhatsApp to check stock or pre-order options.`;
    //     setTimeout(() => {
    //         showNotificationalert.value = false;
    //     }, 3000);
    //     return;
    // }
    cart.value.push({
        ...product,
        selectedColor: {
            code_palete: selectedVariant.color.image,
            name: selectedVariant.color.name,
        },
        selectedWoods: { name: selectedVariant.wood.name },
        quantity: quantity.value,
        price: selectedVariant.price, // Menyimpan harga berdasarkan varian yang dipilih
    });

    // Simpan ke localStorage
    localStorage.setItem("cart", JSON.stringify(cart.value));

    // Tampilkan notifikasi
    showNotification.value = true;
    notificationMessage.value = `Produk ${product.name} dengan warna ${selectedVariant.color.name} dan kayu ${selectedVariant.wood.name} telah ditambahkan ke keranjang!`;
    setTimeout(() => {
        showNotification.value = false;
    }, 3000);
};
// Dapatkan daftar warna unik dan kayu yang sesuai
const uniqueColors = computed(() => {
    if (!props.product?.variants) return [];

    const grouped = {};
    props.product.variants.forEach((variant) => {
        if (!grouped[variant.color.id]) {
            grouped[variant.color.id] = {
                color: variant.color,
                woods: [],
            };
        }
        if (variant.wood) {
            grouped[variant.color.id].woods.push(variant.wood);
        }
    });

    return Object.values(grouped);
});
</script>
