<template>
    <div class="fixed top-0 w-full bg-white p-2 z-50 hidden md:block uppercase">
        <div
            v-if="searchOpen"
            class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
        >
            <div
                class="relative w-full max-w-md px-4 bg-white p-6 rounded-lg shadow-lg"
            >
                <!-- Judul -->
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-600 animate-pulse">
                        IA PROJECT
                    </h1>
                </div>

                <!-- Input Pencarian -->
                <input
                    type="text"
                    placeholder="Search..."
                    class="w-full p-4 border text-black border-[#D4A373] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4A373]"
                    v-model="query"
                />

                <!-- Tombol Search -->
                <button
                    class="w-full bg-[#D4A373] rounded-lg mt-3 text-gray-600 p-3 font-bold hover:bg-[#D4A373]"
                    type="button"
                    @click="doSearch"
                >
                    <i class="mdi mdi-magnify"></i> Search
                </button>

                <!-- Tombol Close -->
                <button
                    @click="toggleSearch"
                    class="absolute top-3 right-3 text-gray-600 hover:text-red-500"
                    aria-label="Close"
                >
                    <i class="mdi mdi-close-circle-outline text-3xl"></i>
                </button>
            </div>
        </div>
        <header class="flex justify-between items-center px-4">
            <div class="flex items-center gap-2">
                <img class="w-14" src="/logo.jpg" alt="IA Project" />
                <span class="font-bold text-xl text-gray-700 poppins-bold"
                    >NAME FURNITURE</span
                >
            </div>

            <nav class="flex-1 mx-10">
                <ul
                    class="flex justify-center gap-20 font-bold text-xl text-gray-500"
                >
                    <li class="hover:text-[#D4A373]">
                        <Link href="/">Home</Link>
                    </li>
                    <li class="hover:text-[#D4A373]">
                        <Link href="/products">Product</Link>
                    </li>
                    <li class="relative hover:text-[#D4A373]">
                        <button
                            id="dropdownButton"
                            @click="toggleDropdown"
                            type="button"
                            aria-expanded="true"
                            aria-haspopup="true"
                        >
                            CATEGORY
                            <i class="mdi mdi-chevron-down"></i>
                        </button>
                        <div
                            v-if="isOpen"
                            class="origin-top-right absolute mt-2 w-56 rounded-md shadow-lg bg-[#D4A373] ring-1 ring-black ring-opacity-5"
                        >
                            <div
                                class="py-1"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="options-menu"
                            >
                                <Link
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#2E2E2E] hover:text-[#F5F5F5]"
                                    role="menuitem"
                                    v-for="(cat, index) in Categories"
                                    :href="'/category/' + cat.id"
                                    >{{ cat.name }}</Link
                                >
                            </div>
                        </div>
                    </li>
                    <li class="hover:text-[#D4A373]">
                        <Link href="/linker">Contact Us</Link>
                    </li>
                    <li class="hover:text-[#D4A373]">
                        <Link href="/galery">Gallery</Link>
                    </li>
                </ul>
            </nav>
            <div class="flex items-center space-x-3">
                <!-- Tombol Cart -->
                <a
                    href="/cart"
                    class="relative flex items-center justify-center rounded-xl p-2 text-gray-700 transition"
                    type="button"
                    role="button"
                    @click="toggleCart"
                >
                    <i class="mdi mdi-cart text-2xl"></i>
                    <!-- Notifikasi jumlah item -->
                    <span
                        v-if="cart.length > 0"
                        class="absolute top-0 right-0 transform translate-x-1 -translate-y-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md border border-white"
                    >
                        {{ cart.length }}
                    </span>
                </a>

                <!-- Tombol Search -->
                <button
                    class="flex items-center justify-center rounded-xl p-2 text-gray-700 transition"
                    type="button"
                    role="button"
                    @click="toggleSearch"
                >
                    <i class="mdi mdi-magnify text-2xl"></i>
                </button>
            </div>
        </header>
    </div>

    <div
        class="fixed bottom-0 left-0 right-0 bg-gray-100 p-3 mb-1 z-50 rounded-lg md:hidden"
    >
        <nav class="flex justify-around items-center text-[#D4A373]">
            <a href="/" class="flex flex-col items-center hover:text-black">
                <i class="mdi mdi-home-outline"></i>
                <span class="text-xs">Home</span>
            </a>
            <a
                href="/products"
                class="flex flex-col items-center hover:text-black"
            >
                <i class="mdi mdi-cube-outline"></i>
                <span class="text-xs">Product</span>
            </a>
            <div class="relative" @click="toggleDropdown">
                <a class="flex flex-col items-center hover:text-black">
                    <i class="mdi mdi-tag-multiple"></i>
                    <span class="text-xs">Category</span>
                </a>
                <div
                    v-if="isOpen"
                    class="absolute bottom-12 w-screen bg-white rounded-lg"
                >
                    <ul class="flex flex-col justify-center p-3">
                        <li
                            v-for="(category, index) in Categories"
                            :key="index"
                            class="py-1"
                        >
                            <Link
                                :href="`/category/${category.id}`"
                                class="text-black hover:text-[#D4A373]"
                            >
                                {{ category.name }}
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <a
                href="/linker"
                class="flex flex-col items-center hover:text-black"
            >
                <i class="mdi mdi-phone-outline"></i>
                <span class="text-xs">Contact Us</span>
            </a>
            <a
                href="/galery"
                class="flex flex-col items-center hover:text-black"
            >
                <i class="mdi mdi-information-outline"></i>
                <span class="text-xs">Gallery</span>
            </a>
        </nav>
    </div>

    <div
        class="fixed top-0 left-0 w-full bg-white shadow-md z-50 px-4 py-3 flex md:hidden justify-between items-center"
    >
        <!-- Logo & Nama Brand -->
        <div class="flex items-center space-x-2">
            <img src="/logo.jpg" class="w-10 h-10 object-cover rounded-md" />
            <h1 class="text-xl font-bold text-gray-800">NAME FURNITURE</h1>
        </div>

        <!-- Cart & Search -->
        <div class="flex items-center space-x-4">
            <!-- Cart -->
            <div class="relative">
                <a
                    href="/cart"
                    class="flex items-center text-gray-700 hover:text-black"
                >
                    <i class="mdi mdi-cart-outline text-2xl"></i>
                    <span
                        v-if="cart.length > 0"
                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md border border-white"
                    >
                        {{ cart.length }}
                    </span>
                </a>
            </div>

            <!-- Search -->
            <button
                class="flex items-center text-gray-700 hover:text-black"
                type="button"
                role="button"
                @click="toggleSearch"
            >
                <i class="mdi mdi-magnify text-2xl"></i>
            </button>
            <div
                v-if="searchOpen"
                class="fixed inset-0 flex items-center justify-center z-50 p-10"
            >
                <div
                    class="relative w-full max-w-md px-4 bg-white p-6 rounded-lg shadow-lg"
                >
                    <!-- Judul -->
                    <div class="text-center mb-6">
                        <h1
                            class="text-3xl font-bold text-gray-600 animate-pulse"
                        >
                            IA PROJECT
                        </h1>
                    </div>

                    <!-- Input Pencarian -->
                    <input
                        type="text"
                        placeholder="Search..."
                        class="w-full p-4 border text-black border-[#D4A373] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4A373]"
                        v-model="query"
                    />

                    <!-- Tombol Search -->
                    <button
                        class="w-full bg-[#D4A373] rounded-lg mt-3 text-gray-600 p-3 font-bold hover:bg-[#D4A373]"
                        type="button"
                        @click="doSearch"
                    >
                        <i class="mdi mdi-magnify"></i> Search
                    </button>

                    <!-- Tombol Close -->
                    <button
                        @click="toggleSearch"
                        class="absolute top-3 right-3 text-gray-600 hover:text-red-500"
                        aria-label="Close"
                    >
                        <i class="mdi mdi-close-circle-outline text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount, watch } from "vue";

defineProps({ Categories: Object });

const isOpen = ref(false);
const searchOpen = ref(false);
const query = ref("");
const cartCount = ref(5);
const cart = ref([]);
const guestId = ref("");

onMounted(() => {
    let storedGuestId = localStorage.getItem("guestId");
    if (!storedGuestId) {
        storedGuestId = "guest_" + Math.random().toString(36).substr(2, 9);
        localStorage.setItem("guestId", storedGuestId);
    }

    guestId.value = storedGuestId;
    cart.value = JSON.parse(localStorage.getItem("cart")) || [];
});
const toggleCart = () => {
    console.log("Cart clicked");
};
const doSearch = async () => {
    if (query.value == "") return;
    router.visit("/products?filter=search&q=" + query.value, {
        preserveScroll: true,
    });
};

const toggleSearch = () => {
    searchOpen.value = !searchOpen.value;
};

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    console.log(isOpen.value);
};

const closeDropdown = (event) => {
    if (!event.target.closest(".relative")) {
        isOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener("click", closeDropdown);
});

onBeforeUnmount(() => {
    window.removeEventListener("click", closeDropdown);
});
</script>
