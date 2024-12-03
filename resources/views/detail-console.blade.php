<x-layout>
    <x-navbar></x-navbar>
    <section class="bg-neutral-900 min-h-screen flex items-center justify-center py-16 mt-7">
        <!-- Detail Produk Console -->
        <div class="bg-neutral-800 rounded-lg shadow-lg max-w-4xl w-full p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gambar Console -->
                <div class="relative overflow-hidden rounded-lg group">
                    <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                        src="{{ asset('storage/img/Supermario.jpg') }}" alt="PlayStation 5">
                </div>

                <!-- Informasi Console -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-yellow-400 mb-4 font-pixelify">PlayStation 5</h1>
                    <p class="text-sm text-gray-400 italic mb-6">
                        Konsol gaming terbaru dengan teknologi canggih, menghadirkan pengalaman bermain yang belum
                        pernah Anda rasakan sebelumnya!
                    </p>

                    <p class="text-xl font-semibold text-yellow-500 mb-4 ">Rp 7.500.000</p>

                    <div class="flex items-center gap-4">
                        <button
                            class="rounded-full bg-yellow-400 py-2 px-6 text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all font-pixelify">
                            Beli Sekarang
                        </button>
                        <button
                            class="rounded-full border-2 border-yellow-400 py-2 px-6 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all font-pixelify">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Tambahan -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-yellow-400 mb-4 font-pixelify">Deskripsi Produk</h2>
                <p class="text-gray-400 text-sm leading-relaxed">
                    PlayStation 5 adalah konsol generasi terbaru dari Sony yang menawarkan performa luar biasa dengan
                    prosesor ultra cepat, grafis memukau, dan fitur SSD yang revolusioner. Konsol ini adalah pilihan
                    terbaik untuk para gamer yang ingin menikmati game favorit mereka dalam resolusi hingga 4K.
                </p>
            </div>

            <!-- Spesifikasi Produk -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-yellow-400 mb-4 font-pixelify">Spesifikasi</h2>
                <ul class="text-sm text-gray-400 list-disc ml-6 space-y-2">
                    <li>Prosesor: AMD Ryzen Zen 2</li>
                    <li>GPU: AMD RDNA 2</li>
                    <li>RAM: 16GB GDDR6</li>
                    <li>Storage: 825GB SSD</li>
                    <li>Resolusi: Hingga 4K</li>
                    <li>Fitur: Backward compatibility, ray tracing</li>
                </ul>
            </div>
        </div>
    </section>
    <x-footer></x-footer>
</x-layout>
