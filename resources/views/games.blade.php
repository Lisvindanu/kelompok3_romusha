<x-layout>
    <x-navbar></x-navbar>
        {{-- Produk Game --}}
        <div class="flex min-h-screen flex-col items-center px-4 md:px-10 mt-10 zoom-responsive">
            <!-- Title -->
            <h1 class="text-4xl font-bold mb-8 mt-10 text-center text-white zoom-responsive font-pixelify">Game</h1>
            <!-- Cards Wrapper -->
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 zoom-responsive">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
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
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
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
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
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
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 6 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 7 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 8 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 9 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 10 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 11 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Card 12 -->
                    <div
                        class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                        <div class="h-72 w-56 overflow-hidden rounded-lg">
                            <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario">
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                            <div
                                class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                <h1 class="text-lg md:text-xl font-bold text-white">Super Mario</h1>
                                <p
                                    class="text-sm italic text-white mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda est esse illum?
                                </p>
                                <button
                                    class="rounded-full shadow shadow-black/60 bg-yellow-400 py-2 px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Beli Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footer></x-footer>
</x-layout>
