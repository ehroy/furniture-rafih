<template>
    <div>
        <JustHead :Global="Global" :title="'Produk Kami'"/>
        <Navbar :Categories="Categories"/>
        <br><br><br>
        <ProductPage :Products="Products" :HeadTitle="HeadTitle" :Action="Action" :Categories="Categories" :Filter="Filter" :Global="Global" :FilterQuery="FilterQuery"/>
    </div>
</template>

<script setup>
import Navbar from '../../Components/Navbar.vue';
import CategoryPage from '../../Components/CategoryPage.vue';
import ProductPage from '../../Components/ProductPage.vue';
import JustHead from '../../Components/JustHead.vue';

defineProps({
    Products: Object,
    Categories: Object,
    ActiveCat: String,
    SubCategories: Object,
    Filter: String,
    Global: Object ,
    FilterQuery:String
});
const HeadTitle = "Produk Kami";
const Action = "kategori";
</script>