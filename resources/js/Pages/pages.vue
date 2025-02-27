<template>

    <div>
        <JustHead :Global="Global" :title="post.title"/>
        <Navbar :Categories="Categories"/>
            <br><br>
            <div class="container mx-auto mt-10 w-1/2">
                <h1 class="text-3xl font-bold text-center md:text-left mb-4 poppins-bold"><i class="mdi mdi-newspaper"></i> {{post.title }}</h1>
                    <div class="prose lg:prose-xl" v-html="post.content"></div>
            </div>
    </div>
</template>

<script setup>
import JustHead from '../Components/JustHead.vue';
import Navbar from '../Components/Navbar.vue';

defineProps({ page: Object, post: Object , Categories: Object,
    Global: Object})

</script>