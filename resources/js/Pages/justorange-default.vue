<template>
	<JustHead :Global="Global" />
	<div>
		<Navbar :Categories="Categories" />

		<div class="hidden md:block relative">
			<section class="grid grid-cols-2 gap-4 ">

				<div class="flex flex-col  justify-center ">
					
				<div class="flex flex-col items-center">
					<h1 class="text-8xl font-bold w-2/3 mb-5 poppins-bold animate-pulse">
						 <span class="text-gray-600">IA PROJECT</span>
					</h1>

					<p class="text-secondary w-3/4 text-lg text-left p-2">
						Kami bergerak di bidang desain interior dan penyediaan 
						furniture berkualitas. Dengan tim ahli bidang kayu dan
						konstruksi furniture yang estetik dan tahan lama untuk
						berbagai kebutuhan desain interior maupun eksterior.
					</p>
				</div>


					<div class="mt-5 px-32"><br>
					<Link href="/products" class="bg-amber-400 p-3 rounded text-gray-600 hover:bg-amber-600 mt-5">Belanja sekarang!</Link>
					</div>
					
				</div>
				
				<div>
					<img src="/assets/images/kursi-bg.png" alt="" class="hover:sepia" />
				</div>
				
			</section>
			<div class="px-5 py-5">
					<b>&copy; IA PROJECT</b> | <i class="italic">Bawu Batealit, Jepara,Jawa Tengah</i>
				</div>
			<div>
				
			</div>
		</div>

		<RecommendedPage :ProductsRecommended="ProductsRecommended" :Global="Global"/>
		

		<CategoryPage :Categories="Categories" :SubCategories="SubCategories" :ActiveCat="ActiveCat" />

		<ProductPage :Products="Products" :HeadTitle="HeadTitle" :Action="Action" :Filter="Filter" :Global="Global" :FilterQuery="FilterQuery"/>

		<Testimonial :Testimonials="Testimonials" />

	

		<Footer :Global="Global" :Socmed="Socmed" :Pages="Pages" />
	</div>
</template>


<script setup>
import Navbar from '../Components/Navbar.vue';
import CategoryPage from '../Components/CategoryPage.vue';
import Testimonial from '../Components/Testimonial.vue';
import ProductPage from '../Components/ProductPage.vue';
import RecommendedPage from '../Components/RecommendedPage.vue';
import Footer from '../Components/Footer.vue';
import JustHead from '../Components/JustHead.vue';
import {Link} from '@inertiajs/vue3';

defineProps({ ProductsRecommended:Object,
			  Products: Object, 
			  Categories: Object, 
			  SubCategories: Object, 
			  ActiveCat: String,
			  Filter: String, 
			  Global : Object,
			  Testimonials: Object,
			  Socmed: Object,
			  Pages: Object,
			  FilterQuery: String
			 });
const HeadTitle = 'Produk Kami';
const Action = 'all';

</script>