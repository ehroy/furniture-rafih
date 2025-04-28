<template>
    <div>
        <JustHead :Global="Global" :title="product.name" />
        <Navbar :Categories="Categories" />
        <div class="mt-20">{{ Dataimage() }}</div>
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
const Dataimage = () => {
    const images = [];

    // Ambil default image dulu
    if (props.Products[0]?.image) {
        images.push({
            name: "default",
            image: props.Products[0].image,
        });
    }

    // Lalu ambil variant images
    props.Products[0]?.variants.forEach((variant) => {
        if (variant.color?.name && variant.color?.image?.length) {
            variant.color.image.forEach((img) => {
                images.push({
                    name: variant.color.name,
                    image: img, // <- pastikan di dalam `color.image` ada properti `url`
                });
            });
        }
    });

    return images;
};
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
