<template>
	<div class="hidden md:block">
		<section class="flex justify-center gap-32 bg-[#222831] md:px-72 md:py-10">
			<div class="flex w-2/3 justify-center gap-5">
				<img src="/assets/images/sign-up.png" alt="" />
				<div>
					<h4 class="text-3xl font-bold text-[#EEEEEE]">
						Tartarik dengan produk kami?
					</h4>
					<p class="text-white text-xl">
						Jangan lewatkan penawaran menarik dan terbaru dari kami,
						dengan memasukan nomer whatsapp anda. 
					</p>
				</div>
			</div>
			<form class="w-1/3" action="#">
				<div class="flex flex-col justify-center items-center gap-5">
					<input type="email" class="bg-white text-gray-500 rounded-full py-3 text-center w-full border-2"
						placeholder="Nomor kamu!" />
					<input type="submit"
						class="bg-transparent border border-white text-white rounded-full py-3 text-center w-full"
						value="Dapatkan penawaran" />
				</div>
			</form>
		</section>
	</div>
</template>