<template>
    <JustHead :Global="Global" />
    <Navbar :Categories="Categories" />
    <GaleryPage :Gallery="Gallery" :Categories="Categories" />
    <Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
</template>
<script setup>
import GaleryPage from "../Components/GaleryPage.vue";
import Navbar from "../Components/Navbar.vue";
import JustHead from "../Components/JustHead.vue";
import Footer from "../Components/Footer.vue";
defineProps({
    Gallery: Object,
    Global: Object,
    Categories: Object,
    Pages: Object,
    Socmed: Object,
});
</script>
