<x-layout>
    <x-navbar></x-navbar>
    <section class="bg-neutral-900 min-h-screen flex items-center justify-center py-16 mt-7">
        <!-- Detail Produk -->
        <div class="bg-neutral-800 rounded-lg shadow-lg max-w-4xl w-full p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gambar Produk -->
                <div class="relative overflow-hidden rounded-lg group">
                    <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                        src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                </div>

                <!-- Informasi Produk -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-yellow-400 mb-4 font-pixelify">Super Mario</h1>
                    <p class="text-sm text-gray-400 italic mb-6 ">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, repellendus. Distinctio
                        molestias illum voluptas.
                    </p>

                    <p class="text-xl font-semibold text-yellow-500 mb-4">Rp 250.000</p>

                    <div class="flex items-center gap-4 font-pixelify">
                        <button
                            class="rounded-full bg-yellow-400 py-2 px-6 text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all">
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
                    Super Mario adalah game ikonik yang telah menjadi favorit para gamer sejak lama. Dengan gameplay
                    yang
                    seru dan grafis yang menarik, game ini cocok untuk semua kalangan. Miliki koleksi ini untuk
                    melengkapi
                    pengalaman gaming Anda.
                </p>
            </div>

            <!-- Spesifikasi Produk -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-yellow-400 mb-4 font-pixelify">Spesifikasi</h2>
                <ul class="text-sm text-gray-400 list-disc ml-6 space-y-2">
                    <li>Platform: Nintendo Switch</li>
                    <li>Genre: Action/Platformer</li>
                    <li>Developer: Nintendo</li>
                    <li>Release Date: September 2024</li>
                </ul>
            </div>
        </div>
    </section>
    <x-footer></x-footer>
</x-layout>
