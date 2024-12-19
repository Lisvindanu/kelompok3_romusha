<x-layout>
    <x-navbar></x-navbar>
    {{-- Halaman Keranjang Belanja --}}
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-bold mb-6 mt-10 text-center text-white font-pixelify">
            Keranjang Belanja
        </h1>

        <!-- Keranjang Wrapper -->
        <div class="w-full max-w-5xl bg-neutral-800 shadow-md rounded-lg p-4 sm:p-6">
            <!-- Tabel Produk -->
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-neutral-700 text-gray-300 uppercase text-[10px] sm:text-xs">
                        <th class="px-2 sm:px-4 py-2 sm:py-3">
                            <input type="checkbox" id="select-all"
                                class="w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 bg-gray-300 rounded-md border-gray-500" />
                        </th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Produk</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Harga</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Jumlah</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh Produk -->
                    <tr class="border-b border-neutral-700">
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                            <input type="checkbox"
                                class="product-check w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 bg-gray-300 rounded-md border-gray-500" />
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 flex items-center space-x-2 sm:space-x-4">
                            <img src="{{ asset('storage/img/Supermario.jpg') }}" alt="Super Mario"
                                class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-lg border border-gray-600">
                            <span class="font-medium text-white text-xs sm:text-sm">Super Mario</span>
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">Rp 150.000</td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                            <input type="number" value="1" min="1"
                                class="w-12 sm:w-16 text-center border-gray-500 bg-neutral-700 text-white rounded-lg text-xs sm:text-sm">
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">Rp 150.000</td>
                    </tr>
                    <!-- Produk Lainnya -->
                    <tr class="border-b border-neutral-700">
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                            <input type="checkbox"
                                class="product-check w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 bg-gray-300 rounded-md border-gray-500" />
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 flex items-center space-x-2 sm:space-x-4">
                            <img src="{{ asset('storage/img/Supermario.jpg') }}" alt="Zelda"
                                class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-lg border border-gray-600">
                            <span class="font-medium text-white text-xs sm:text-sm">The Legend of Zelda</span>
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">Rp 200.000</td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                            <input type="number" value="1" min="1"
                                class="w-12 sm:w-16 text-center border-gray-500 bg-neutral-700 text-white rounded-lg text-xs sm:text-sm">
                        </td>
                        <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">Rp 200.000</td>
                    </tr>
                </tbody>
            </table>

            <!-- Button Checkout -->
            <div class="mt-6 flex flex-col sm:flex-row sm:justify-between items-center gap-4">
                <!-- Tombol Hapus Produk Terpilih -->
                <button
                    class="w-full sm:w-auto rounded-full border-2 border-yellow-400 py-2 px-6 text-[10px] sm:text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all font-pixelify">
                    Hapus Produk Terpilih
                </button>

                <!-- Tombol Checkout Produk Terpilih -->
                <button
                    class="w-full sm:w-auto rounded-full bg-yellow-400 py-2 px-6 text-[10px] sm:text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all font-pixelify">
                    Checkout Produk Terpilih
                </button>
            </div>

        </div>
    </div>
    <x-footer></x-footer>

    <!-- Tautkan script JS -->
    <script src="{{ asset('js/cart.js') }}"></script>
</x-layout>
