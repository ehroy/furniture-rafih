<template>
    <div>
       <JustHead :Global="Global" :title="'Kategori ' +Category.name"/>
        <Navbar :Categories="Categories"/>
        <br><br>
     
       <div class="container mx-auto py-5 px-5 md:py-20 md:px-20">
        <div class="border-b-2 border-black mt-12">

<nav class="flex items-center space-x-2 text-gray-700 py-4">
    <Link href="/" class="hover:text-gray-900"><i class="mdi mdi-home"></i> Home</Link>
    <span>></span>
    <Link :href="'/category/'+Category.id" class="hover:text-gray-900"><i class="mdi mdi-tag"></i> {{Category.name}}</Link>
    <span>></span>
    <span class="text-gray-500">{{ subCategory?.name ?? 'All' }}</span>
</nav>
</div>
        <div class="border-b-2 border-gray-700 w-3/12 mt-10">
        <h1 class="mt-5 mb-10 text-3xl poppins-bold uppercase"><i class="mdi mdi-tag"></i> {{ Category.name }}</h1>
      </div>
        <div class="flex justify-center items-center text-sm font-medium text-center text-gray-500  dark:text-gray-400 dark:border-gray-700 mt-10">
                <br><br>

                <ul class="flex flex-wrap -mb-px border-b-2 border-gray-300">
                    <li class="me-2" v-for="(cat, index) in SubCategories" :key="index">

                        <Link :href="'?sub=' + cat.id"
                            :class="(ActiveCat == cat.id) ? 'inline-block p-4 border-2 border-transparent  bg-amber-400' : 'inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300'"
                            preserve-scroll>{{ cat.name }}</Link>
                    </li>

                </ul>
            </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mb-10 mt-10 ">
        <div class="rounded-lg " v-for="(product, index) in Products" :key="index">
          <img class="w-full rounded-t-lg" :src="helpers.imageUrl(product.image)" :alt="product.name" />
          <div class="flex flex-col gap-2 text-gray-600 bg-[#FFCC4C] p-5 rounded-b-lg hover:shadow-lg">
            <Link :href="'/product/' + product.slug"><h4 class="font-bold hover:underline">{{ product.name }}</h4></Link>
           
            <div class="flex flex-col md:flex-row md:justify-between">
              <b class="text-sm mt-2">{{ product.price == 0 ? 'Tanya Admin' : helpers.rupiah(product.price) }}</b>
              <span class="text-sm mt-2"><i class="mdi mdi-tag"></i> {{ product.subcategory.name }}</span>
            </div>
            <a class="bg-amber-500 px-8 py-2 rounded-full text-gray-600 font-bold text-center hover:bg-amber-600 hover:text-white uppercase text-sm md:text-lg" :href="helpers.WaButton(Global,'/product/'+product.slug)"><i class="mdi mdi-whatsapp"></i> {{Global.Settings.action_button_text}}</a>
          </div>
        </div>
      </div>

     
       </div>
    </div>
</template>

<script setup>
import Navbar from '../../Components/Navbar.vue';
import CategoryPage from '../../Components/CategoryPage.vue';
import ProductPage from '../../Components/ProductPage.vue';
import {inject} from 'vue';
import {Link} from '@inertiajs/vue3';
import JustHead from '../../Components/JustHead.vue';

defineProps({
            Products: Object,
            Categories: Object,
            SubCategories: Object,
            Filter: String,
            ActiveCat: String,
            Category: Object,
            subCategory: Object,
            Global: Object });

const Action = "kategori";
const helpers = inject('helpers');
</script>