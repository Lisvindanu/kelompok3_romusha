<x-layout>
    {{-- Hero Section --}}
    <div class="relative bg-cover bg-center bg-no-repeat text-white h-screen flex items-center justify-center py-20 px-6 md:px-12 zoom-responsive"
        style="background-image: url('{{ asset('storage/img/hero.png') }}');">
        <!-- Container -->
        <div class="container flex flex-col md:flex-row items-center relative z-10 zoom-responsive">
            <!-- Latar belakang teks -->
            <div class="md:w-[55%] mb-8 md:mb-0 bg-gray-800 bg-opacity-70 p-6 rounded-lg zoom-responsive">
                <h1 class="text-5xl md:text-7xl font-bold mb-4 font-pixelify">
                    Retro Game Hub
                </h1>
                <p class="text-2xl md:text-3xl mb-6 font-pixelify">
                    Tempat Terbaik untuk Membeli Game dan Console Klasik
                </p>
                <p class="text-base md:text-lg mb-8 font-pixelify">
                    Jelajahi koleksi game nostalgia dan rasakan pengalaman bermain layaknya masa lalu. Belanja mudah,
                    aman, dan cepat!
                </p>
                <a href="#"
                    class="bg-yellow-400 text-red-700 hover:bg-yellow-500 font-semibold py-3 px-6 rounded shadow-md transition duration-300 font-pixelify">
                    Mulai Berbelanja
                </a>
            </div>
        </div>
    </div>

    <!-- Produk Game -->
    <div class="flex min-h-screen flex-col items-center px-4 md:px-10 pt-30 zoom-responsive"
        style="background: linear-gradient(180deg, #d7550a 1%, rgba(255, 255, 255, 0) 15%);">
        <!-- Title -->
        <h1 class="text-4xl font-bold mb-8 mt-40 text-center text-white zoom-responsive font-pixelify">Featured Games
        </h1>
        <!-- Cards Wrapper -->
        <div class="relative w-full overflow-x-auto md:overflow-visible mt-20">
            <div class="flex gap-4 w-max md:grid md:grid-cols-4 md:gap-6 md:w-full">
                <!-- Card 1 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Button lainnya mobile --}}
                <div
                    class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-yellow-400 rounded-full md:hidden self-center">
                    <button class="text-red-700 text-xl">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            {{-- Button lainnya dekstop --}}
            <div class="flex justify-center mt-12">
                <button
                    class="bg-yellow-400 text-red-700 py-2 px-6 sm:px-4 rounded-full text-lg hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 hidden md:block">
                    Tampilkan Lainnya
                </button>
            </div>
        </div>
    </div>

    {{-- Produk Console --}}
    <div class="flex min-h-screen flex-col items-center px-4 md:px-10 pt-30 zoom-responsive">
        <!-- Title -->
        <h1 class="text-4xl font-bold mb-8 mt-40 text-center text-white zoom-responsive font-pixelify">Featured Games
        </h1>
        <!-- Cards Wrapper -->
        <div class="relative w-full overflow-x-auto md:overflow-visible mt-20">
            <div class="flex gap-4 w-max md:grid md:grid-cols-4 md:gap-6 md:w-full">
                <!-- Card 1 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 1 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div
                    class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive w-48 sm:w-64 md:w-72">
                    <div class="h-[16rem] sm:h-[20rem] md:h-[24rem] w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                            src="{{ asset('storage/img/CallofDuty.jpg') }}" alt="Call of Duty">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[45%] group-hover:translate-y-0 transition-all zoom-responsive">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white">Call of Duty</h1>
                            <p
                                class="text-xs sm:text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Experience the thrill of modern warfare!
                            </p>
                            <button
                                class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Button lainnya mobile --}}
                <div
                    class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-yellow-400 rounded-full md:hidden self-center">
                    <button class="text-red-700 text-xl">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            {{-- Button lainnya dekstop --}}
            <div class="flex justify-center mt-12">
                <button
                    class="bg-yellow-400 text-red-700 py-2 px-6 sm:px-4 rounded-full text-lg hover:bg-yellow-500 hover:text-red-800 transition-all duration-300 hidden md:block">
                    Tampilkan Lainnya
                </button>
            </div>
        </div>
    </div>

    {{-- Section About --}}
    <x-about></x-about>
    <x-footer></x-footer>
</x-layout>
