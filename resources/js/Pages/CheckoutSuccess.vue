<template>
    <JustHead :Global="Global" />
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-r p-6 bg-gray-50"
    >
        <div class="bg-white rounded-2xl p-8 max-w-3xl w-full">
            <h1 class="text-2xl font-bold text-green-600 text-center">
                🎉 {{ $t("orderpage.message_order") }}
            </h1>

            <!-- Nomor Order -->
            <p class="mt-2 text-gray-600 text-center text-lg">
                Order Number:
                <span class="font-semibold">{{ order.order_number }}</span>
            </p>
            <p class="mt-2 text-red-500 text-center text-sm">
                📩 {{ $t("orderpage.notice_message") }}
            </p>

            <!-- Tracking Status (Sembunyikan jika status Cancelled) -->
            <div v-if="order.status !== 'cancelled'" class="mt-6">
                <div class="flex justify-between items-center">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.status"
                        class="flex-1 text-center"
                    >
                        <div
                            class="w-10 h-10 mx-auto flex items-center justify-center rounded-full text-white font-bold"
                            :class="stepClass(step.status, index)"
                        >
                            <span v-if="index <= currentIndex">{{
                                stepIcons[step.status]
                            }}</span>
                            <span v-else>{{ index + 1 }}</span>
                        </div>
                        <p
                            class="text-sm mt-2 font-semibold"
                            :class="textClass(step.status)"
                        >
                            {{ step.label }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center mt-2">
                    <div
                        v-for="(step, index) in steps.slice(0, -1)"
                        :key="index"
                        class="flex-1 relative"
                    >
                        <div
                            class="h-1 bg-gray-300 absolute top-1/2 w-full transform -translate-y-1/2"
                        ></div>
                        <div
                            class="h-1 absolute top-1/2 w-full transform -translate-y-1/2 transition-all duration-500"
                            :class="lineClass(index)"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Tampilan khusus jika status Cancelled -->
            <div v-else class="mt-6 flex flex-col items-center text-red-600">
                <div
                    class="w-16 h-16 flex items-center justify-center bg-red-500 text-white rounded-full text-4xl shadow-lg"
                >
                    ❌
                </div>
                <p class="text-lg font-semibold mt-2">
                    {{ $t("orderpage.message_cancel") }}
                </p>
            </div>

            <!-- Pesan berdasarkan Status -->
            <p class="mt-4 text-gray-700 text-lg font-medium text-center">
                {{ statusMessage(order.status) }}
            </p>
            <div class="mt-6 text-center">
                <a
                    :href="
                        helpers.WaButton(
                            Global,
                            '/cart/success/' + order.order_number
                        )
                    "
                    target="_blank"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300"
                >
                    Click For Confirmation Whatsapp
                </a>
            </div>
            <div class="border-t border-gray-300 my-6"></div>

            <h2 class="text-lg font-semibold text-gray-700">
                {{ $t("orderpage.detail_order") }}
            </h2>
            <ul class="mt-4 space-y-4">
                <li
                    v-for="item in order.items"
                    :key="item.id"
                    class="flex items-center bg-gray-100 rounded-lg p-4 shadow-sm"
                >
                    <img
                        :src="helpers.imageUrl(item.product.image[0])"
                        alt="Produk"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-300"
                    />
                    <div class="ml-4">
                        <p class="text-gray-900 font-semibold">
                            {{ item.product.name }}
                        </p>
                        <p class="text-gray-600">
                            Quantity: {{ item.quantity }}
                        </p>
                    </div>
                </li>
            </ul>

            <div class="mt-6 text-center">
                <Link
                    href="/"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300"
                >
                    {{ $t("homepage.back_home") }}
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import JustHead from "../Components/JustHead.vue";
import { inject, computed } from "vue";
import { Link } from "@inertiajs/vue3";

const helpers = inject("helpers");

const props = defineProps({
    Global: Object,
    order: Object,
});

// Definisi status tracking
const steps = [
    { status: "pending", label: "Pending" },
    { status: "confirmed", label: "Confirmed" },
    { status: "processing", label: "Processing" },
    { status: "completed", label: "Completed" },
];

// Ikon untuk setiap status
const stepIcons = {
    pending: "⏳",
    confirmed: "✅",
    processing: "🚛",
    completed: "🎉",
};

// Index langkah saat ini berdasarkan status order
const currentIndex = computed(() =>
    steps.findIndex((step) => step.status === props.order.status)
);

// Fungsi untuk menentukan kelas warna bulatan status
const stepClass = (status, index) => {
    if (index <= currentIndex.value) return "bg-green-500";
    if (index === currentIndex.value) return "bg-blue-500";
    return "bg-gray-300";
};

// Fungsi untuk menentukan warna teks status
const textClass = (status) => "text-gray-700";

// Fungsi untuk menentukan warna garis progres
const lineClass = (index) => {
    return index < currentIndex.value ? "bg-green-500" : "bg-gray-300";
};

// Fungsi untuk pesan berdasarkan status
const statusMessage = (status) => {
    switch (status) {
        case "pending":
            return "⏳ Your order is waiting for confirmation.";
        case "confirmed":
            return "✅ Your order has been confirmed by the admin.";
        case "processing":
            return "🚛 Your order is being processed. Please wait.";
        case "completed":
            return "🎉 Your order is complete! Thank you for shopping.";
        case "cancelled":
            return "❌ Your order has been cancelled. Contact support if you have any questions.";
        default:
            return "🔄 Unknown order status.";
    }
};
</script>
