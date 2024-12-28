<x-layout>
    <x-navbar></x-navbar>

    <div class="container min-h-screen mx-auto p-8 mt-14">
        <!-- Wrapper untuk Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Formulir Pengiriman -->
            <div class="lg:col-span-2 bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Formulir Pembayaran</h2>
                <form action="/place-order" method="POST" class="space-y-8">
                    @csrf
                    <!-- Input Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="name" class="block text-lg text-gray-400 font-pixelify">Nama</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                rows="1"
                                required 
                                class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg">
                        </div>
                        <div>
                            <label for="phone" class="block text-lg text-gray-400 font-pixelify">Nomor Handphone</label>
                            <input 
                                id="phone"
                                name="phone"
                                type="text"
                                required
                                class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg"
                                value=""
                                />
                        </div>
                    </div>
                    <div>
                        <label for="alamat" class="block text-lg text-gray-400 font-pixelify">Alamat</label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2" 
                            required 
                            class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg"></textarea>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Produk -->
            <div class="bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Ringkasan Produk</h2>
                <div class="space-y-6">
                    <!-- Produk A -->
                    <div class="flex justify-between items-center text-lg">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/50" alt="Produk A" class="w-12 h-12 object-cover rounded-md mr-4">
                            <span>Produk A</span>
                        </div>
                        <span>Rp 50,000</span>
                    </div>
                    <!-- Produk B -->
                    <div class="flex justify-between items-center text-lg">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/50" alt="Produk B" class="w-12 h-12 object-cover rounded-md mr-4">
                            <span>Produk B</span>
                        </div>
                        <span>Rp 100,000</span>
                    </div>
                    <!-- Produk C -->
                    <div class="flex justify-between items-center text-lg">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/50" alt="Produk C" class="w-12 h-12 object-cover rounded-md mr-4">
                            <span>Produk C</span>
                        </div>
                        <span>Rp 200,000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="bg-neutral-800 rounded-lg shadow p-8 mt-8 text-gray-300">
            <h2 class="text-2xl font-bold mb-8 text-yellow-400">Ringkasan Pembayaran</h2>
            <div class="space-y-6">
                <!-- Subtotal -->
                <div class="flex justify-between items-center text-lg">
                    <span>Subtotal</span>
                    <span>Rp 350,000</span>
                </div>
                <div class="border-t border-gray-700 mt-4"></div>
                <!-- Biaya Pengiriman -->
                <div class="flex justify-between items-center text-lg mt-4">
                    <span>Biaya Pengiriman</span>
                    <span>Rp 50,000</span>
                </div>
                <div class="border-t border-gray-700 mt-4"></div>
                <!-- Total Pembayaran -->
                <div class="flex justify-between items-center text-xl font-bold mt-4">
                    <span>Total Pembayaran</span>
                    <span class="text-yellow-500">Rp 400,000</span>
                </div>
                <div class="border-t border-gray-700 mt-6"></div>
            </div>

            <!-- Tombol Buat Pesanan -->
            <div class="mt-8 flex justify-center">
                <button class="bg-yellow-500 text-red-800 rounded-md py-2 px-6 text-lg hover:bg-yellow-400 shadow-lg transform hover:scale-105 transition-all">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</x-layout>
