<template>
    <JustHead :Global="Global" :title="'Hubungi Kami'"/>
    <div>
        <div class="bg-gradient-to-r from-[#393E46] via-[#FFD369] to-[#EEEEEE] p-3">
            <div
                class="border-2 border-[#393E46] rounded-xl w-full md:w-2/4 mx-auto p-5 bg-gray-300 text-black flex flex-col shadow-xl h-svh    ">
                <img src="/logo.jpg"
                    class="w-20 shadow border-2 border-[#393e46] rounded-full place-self-center animate-bounce">

                <h1 class="text-black place-self-center text-xl font-bold mt-2">IAPROPERTY PROJECT</h1>

                <div class="container text-center mt-5">
                    <div v-for="(p, i) in linker" :key="i">
                        <a :href="'/rdr/'+p.label + '?ref=iaproperty-web'" target="_blank">
                            <div
                                class="w-full border-2 rounded-full bg-gradient-to-r from-[#EEEEEE] via-white to-[#FFD369] border-1 p-2 hover:bg-gradient-to-r hover:from-[#FFD369] hover:via-white hover:to-[#eeeeee] hover:animate-pulse  hover:border-black mb-2 font-bold">
                                {{ p.label.toUpperCase() }}
                            </div>
                        </a>
                    </div>

                </div>

                <br><br>
                <h3 class="text-md text-center">Share Link to</h3>&nbsp;&nbsp;
                <div class="flex flex-row gap-2 justify-center">
                    <a href="" class="bg-blue-500 hover:bg-blue-700 rounded p-3 text-lg text-white"><i class="mdi mdi-facebook "></i></a>
                    <a href="" class="bg-black hover:bg-gray-600 rounded p-3 text-lg text-white"><i class="mdi mdi-twitter "></i></a>
                    <a href="" class="bg-green-500 hover:bg-green-700 rounded p-3 text-lg text-white"><i class="mdi mdi-whatsapp "></i></a>
                    <a href="" class="bg-yellow-500 hover:bg-yellow-300 rounded p-3 text-lg text-white"><i class="mdi mdi-link"></i></a>
                </div>
                <div class="text-center bottom-0 absolute mt-5">
                    &copy; {{ new Date().getFullYear() }} IA Property. 
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import JustHead from '../Components/JustHead.vue';
defineProps({ linker: Object  , Global : Object})

</script>