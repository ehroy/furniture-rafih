<template>
    <div class="hidden md:block">
        <section
            class="flex flex-col items-center bg-accent pt-20 pb-56 relative"
        >
            <h2
                class="text-7xl text-gray-500 text-shadow-custom text-center mb-10 poppins-bold"
            >
                Testimoni
            </h2>
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 bg-[#eeeeee] px-10 pt-10 pb-72 w-3/4"
            >
                <div
                    class="rounded-lg bg-white p-5 z-30"
                    v-for="(tes, index) in Testimonials"
                    :key="index"
                >
                    <div class="flex justify-between items-center">
                        <div class="flex justify-center items-center gap-2">
                            <img
                                class="w-14 rounded-full"
                                :src="
                                    'https://ui-avatars.com/api/?name=' +
                                    tes.name
                                "
                                alt=""
                            />
                            <div class="flex flex-col text-gray-600">
                                <p class="font-bold text-sm">{{ tes.name }}</p>
                                <p class="text-xs">{{ tes.email }}</p>
                            </div>
                        </div>
                        <i
                            class="mdi mdi-format-quote-open text-5xl text-amber-600"
                        ></i>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-gray-600 text-sm mt-3 leading-tight">
                            {{ tes.content }}
                        </p>
                        <div class="flex justify-end gap-2">
                            <i
                                class="mdi mdi-star text-3xl text-yellow-400"
                            ></i>
                            <i
                                class="mdi mdi-star text-3xl text-yellow-400"
                            ></i>
                            <i
                                class="mdi mdi-star text-3xl text-yellow-400"
                            ></i>
                            <i
                                class="mdi mdi-star text-3xl text-yellow-400"
                            ></i>
                            <i
                                class="mdi mdi-star text-3xl text-yellow-400"
                            ></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex w-full absolute bottom-0">
                <img
                    src="/assets/images/bg-testimonials.webp"
                    alt="Background Testimonials"
                    class="w-full h-auto"
                />
            </div>
        </section>
    </div>
</template>

<script setup>
defineProps({ Testimonials: Object });
</script>
