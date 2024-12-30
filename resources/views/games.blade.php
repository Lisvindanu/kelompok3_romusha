<x-layout>
    <x-navbar></x-navbar>
    @if (isset($products) && count($products) > 0)
        <div class="flex min-h-screen flex-col items-center px-4 md:px-10 mt-10 zoom-responsive">
            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-8 mt-7 text-center text-white font-pixelify">
                Game
            </h1>
            <!-- Cards Wrapper -->
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 zoom-responsive">
                <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                    @foreach ($products as $product)
                        <div
                            class="group relative items-center justify-center overflow-hidden cursor-pointer hover:shadow-xl hover:shadow-black/30 transition-shadow rounded-lg bg-white zoom-responsive">
                            <div class="h-48 sm:h-56 lg:h-72 w-28 sm:w-full overflow-hidden rounded-lg">
                                <img class="h-full w-full object-cover group-hover:rotate-3 group-hover:scale-125 transition-transform duration-500"
                                    src="{{ 'https://virtual-realm.my.id' . $product['imageUrl'] }}"
                                    alt="{{ $product['name'] }}"
                                    onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black group-hover:from-black/70 group-hover:via-black/60 group-hover:to-black/70 rounded-lg">
                                <div
                                    class="absolute inset-0 flex flex-col items-center justify-center px-2 sm:px-4 text-center translate-y-[60%] group-hover:translate-y-0 transition-all zoom-responsive">
                                    <h1 class="text-sm sm:text-base md:text-lg sm:mb-3 font-bold text-white">
                                        {{ $product['name'] }}</h1>
                                    <a href="/product/{{ $product['id'] }}"
                                        class="rounded-full shadow shadow-black/60 bg-yellow-400 py-1 px-3 sm:py-2 sm:px-4 text-xs sm:text-sm capitalize text-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        Beli Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="flex min-h-screen flex-col items-center justify-center text-center">
            <h1 class="text-2xl font-semibold text-gray-600">Tidak ada produk yang tersedia</h1>
        </div>
    @endif
    <x-footer></x-footer>
</x-layout>
