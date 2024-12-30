<x-layout>
    <x-navbar></x-navbar>
    <section class="bg-neutral-900 min-h-screen flex items-center justify-center py-16 mt-7">
        <!-- Detail Produk -->
        <div class="bg-neutral-800 rounded-lg shadow-lg max-w-4xl w-full p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Gambar Produk -->
                <div class="relative overflow-hidden rounded-lg group">
                    @if (isset($product['imageUrl']) && !empty($product['imageUrl']))
                        <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                            src="{{ 'https://virtual-realm.my.id' . $product['imageUrl'] }}" alt="{{ $product['name'] }}"
                            onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                    @else
                        <div class="w-full h-48 bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400">No image available</span>
                        </div>
                    @endif
                </div>
                <!-- Informasi Produk -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-yellow-400 mb-4">{{ $product['name'] }}</h1>
                    <p class="text-sm text-gray-400 italic mb-6">
                        {{ $product['description'] ?? 'Deskripsi produk tidak tersedia.' }}
                    </p>
                    <p class="text-xl font-semibold text-yellow-500 mb-4">Rp
                        {{ number_format($product['price'], 0, ',', '.') }}</p>
                    <div class="flex items-center gap-4">
                        <button
                            class="rounded-full bg-yellow-400 py-2 px-6 text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all">
                            Beli Sekarang
                        </button>
                        <button
                            class="rounded-full border-2 border-yellow-400 py-2 px-6 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
            <!-- Spesifikasi Produk -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-yellow-400 mb-4">Spesifikasi</h2>
                <div class="text-sm text-gray-400 list-disc ml-6 space-y-2">
                    @if (!empty($product['specifications']))
                        <p>{!! $product['specifications'] !!}</p>
                    @else
                        <p>Spesifikasi tidak tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <x-footer></x-footer>
</x-layout>
