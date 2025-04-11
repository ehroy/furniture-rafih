<template>
    <!-- Container Utama -->
    <div class="py-10 px-5 md:px-20 lg:px-64">
        <div
            class="w-full max-w-6xl p-6 overflow-auto max-h-[calc(100vh-120px)] md:pb-32 pb-96"
        >
            <h2
                class="text-2xl font-bold text-gray-800 mb-5 border-b pb-6 mt-5"
            >
                {{ $t("cart.text") }}
            </h2>

            <!-- Jika Keranjang Kosong -->
            <div
                v-if="cart.length === 0"
                class="text-center py-10 text-gray-600"
            >
                <i class="mdi mdi-cart-off text-5xl"></i>
                <p class="mt-3">{{ $t("cart.text") }}.</p>
                <Link
                    href="/"
                    class="mt-5 inline-block bg-[#424242] text-white px-5 py-2 rounded-lg"
                >
                    {{ $t("cart.back") }}
                </Link>
            </div>

            <!-- Daftar Produk di Keranjang -->
            <div v-else>
                <div
                    v-for="(item, index) in cart"
                    :key="index"
                    class="flex justify-between items-center border-b py-4"
                >
                    <div class="flex items-center space-x-4">
                        <img
                            :src="helpers.imageUrl(item.image)"
                            :alt="item.name"
                            class="w-14 h-14 object-cover rounded-sm"
                        />
                        <div>
                            <h3 class="font-bold text-gray-800">
                                {{ item.name }}
                            </h3>

                            <button
                                @click="removeFromCart(index)"
                                class="text-red-500 mt-2 text-sm hover:underline"
                            >
                                <i class="mdi mdi-trash-can-outline"></i> clear
                            </button>
                        </div>
                    </div>
                    <div v-if="item.selectedColor" class="text-sm">
                        <section
                            class="flex flex-row bg-center text-center items-center"
                        >
                            Colors :

                            <section
                                :style="{
                                    backgroundColor: extractColor(
                                        item.selectedColor.code_palete
                                    ),
                                }"
                                class="w-4 h-4 rounded-full border-2 mt-1 inline-block mx-2"
                            ></section>
                        </section>

                        <section>
                            Wood:
                            {{ item.selectedWoods.name || "Tidak ada" }}
                        </section>
                    </div>
                    <!-- Kontrol Jumlah Produk -->
                    <div class="flex items-center space-x-3">
                        <button
                            @click="decreaseQuantity(index)"
                            class="p-1 bg-gray-200 rounded-full text-xl"
                        >
                            −
                        </button>
                        <span class="font-bold">{{ item.quantity }}</span>
                        <button
                            @click="increaseQuantity(index)"
                            class="p-1 bg-gray-200 rounded-full text-xl"
                        >
                            +
                        </button>
                    </div>

                    <!-- Tampilkan Warna dan Jenis Kayu -->
                </div>

                <!-- Total Harga -->
            </div>
        </div>
    </div>

    <!-- ✅ Form & Checkout Hanya Ditampilkan Jika Keranjang Tidak Kosong -->
    <div
        v-if="cart.length > 0"
        class="fixed bottom-0 left-0 right-0 flex justify-center items-center px-4 pb-[env(safe-area-inset-bottom)] mb-10 md:mb-0 pt-4"
    >
        <div
            class="w-full max-w-6xl mx-auto bg-white p-6 shadow-lg rounded-t-lg"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email Field -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Email <span class="text-red-500">*</span>:
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-amber-300"
                    />
                    <p v-if="emailError" class="text-red-500 text-sm mt-1">
                        Email is required before checkout.
                    </p>
                </div>

                <!-- Address Field -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">
                        Address (Optional):
                    </label>
                    <textarea
                        v-model="form.address"
                        placeholder="Enter your address (optional)"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-amber-300"
                        rows="2"
                    ></textarea>
                </div>
            </div>

            <!-- Tombol Checkout -->
            <button
                @click="checkout"
                class="w-full mt-6 bg-[#424242] text-white py-3 rounded-lg text-center font-bold hover:bg-[#333]"
            >
                Order
            </button>
        </div>
    </div>
    <transition name="fade">
        <div
            v-if="showToast"
            class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg text-center z-50"
        >
            ✅ {{ $t("checkout.message") }} <br />
            {{ $t("checkout.message_text") }}
        </div>
    </transition>
</template>

<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, onMounted, computed, inject, watch } from "vue";

const helpers = inject("helpers");
const cart = ref([]);
const email = ref("");
const emailError = ref(false);
const showToast = ref(false);
const extractColor = (color) => {
    if (!color) return "#FFFFFF"; // Default warna jika kosong
    const hexMatch = color.match(/#([0-9A-Fa-f]{6})/); // Cari warna HEX dalam string
    return hexMatch ? `#${hexMatch[1]}` : color; // Jika ada HEX, ambil HEX, jika tidak, gunakan as-is
};
// Ambil data dari localStorage saat halaman dimuat
onMounted(() => {
    const savedCart = localStorage.getItem("cart");
    if (savedCart) {
        cart.value = JSON.parse(savedCart);
    }
});

// Simpan kembali ke localStorage secara otomatis saat cart berubah
watch(
    cart,
    (newCart) => {
        localStorage.setItem("cart", JSON.stringify(newCart));
    },
    { deep: true }
);

// Format harga rupiah dengan keamanan nilai
const formatRupiah = (value) => {
    if (!value) return "0";
    return value.toLocaleString("id-ID");
};

// Hapus produk dari keranjang
const removeFromCart = (index) => {
    cart.value.splice(index, 1);
};

// Tambah jumlah produk
const increaseQuantity = (index) => {
    cart.value[index].quantity += 1;
};

// Kurangi jumlah produk
const decreaseQuantity = (index) => {
    if (cart.value[index].quantity > 1) {
        cart.value[index].quantity -= 1;
    } else {
        removeFromCart(index);
    }
};

// Hitung total harga
const totalPrice = computed(() =>
    cart.value.reduce((sum, item) => sum + (item.price || 0) * item.quantity, 0)
);

// Validasi email menggunakan regex
const isValidEmail = (email) => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
};

// Gunakan useForm dari Inertia.js
const form = useForm({
    email: "",
    address: "",
    cart: [],
});

// Simulasi Checkout & Kirim ke Controller
const checkout = () => {
    if (!form.email || !isValidEmail(form.email)) {
        emailError.value = true;
        return;
    }

    emailError.value = false;

    // Kirim data ke Laravel controller
    form.cart = cart.value;
    form.post("/cart", {
        onSuccess: () => {
            showToast.value = true; // Tampilkan toast

            setTimeout(() => {
                showToast.value = false;
            }, 3000);

            // Kosongkan keranjang setelah berhasil checkout
            localStorage.removeItem("cart");
            cart.value = [];
            form.email = "";
            form.address = "";
        },
        onError: (errors) => {
            console.error("Checkout failed:", errors);
        },
    });
};
</script>
<style>
/* Animasi Fade */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.9);
}
</style>
