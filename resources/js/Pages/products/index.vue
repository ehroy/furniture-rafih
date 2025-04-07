<template>
    <div>
        <JustHead :Global="Global" :title="'Produk Kami'" />
        <Navbar :Categories="Categories" />

        <ProductPage
            :Products="Products"
            :HeadTitle="HeadTitle"
            :Action="Action"
            :Categories="Categories"
            :Filter="Filter"
            :Global="Global"
            :FilterQuery="FilterQuery"
            :ActiveCat="ActiveCat"
            :SubCategories="SubCategories"
        />
    </div>
    <Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
    <Popup :Global="Global" :Products="Products" />
</template>

<script setup>
import Popup from "../../Components/Popup.vue";
import Footer from "../../Components/Footer.vue";
import Navbar from "../../Components/Navbar.vue";
import CategoryPage from "../../Components/CategoryPage.vue";
import ProductPage from "../../Components/ProductPage.vue";
import JustHead from "../../Components/JustHead.vue";

defineProps({
    Products: Object,
    Categories: Object,
    ActiveCat: String,
    SubCategories: Object,
    Filter: String,
    Global: Object,
    FilterQuery: String,
    Socmed: Object,
    Pages: Object,
});
const HeadTitle = "Produk Kami";
const Action = "kategori";
</script>
