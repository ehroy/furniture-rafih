<script setup>
defineProps({
    Global: Object,
});
import CartPage from "../Components/CartPage.vue";
import Navbar from "../Components/Navbar.vue";
import JustHead from "../Components/JustHead.vue";
</script>

<template>
    <JustHead :Global="Global" />
    <Navbar />
    <CartPage />
</template>
