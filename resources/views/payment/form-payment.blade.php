<x-layout>
    <x-navbar></x-navbar>

    <div class="container min-h-screen mx-auto p-8 mt-14">
        <!-- Wrapper untuk Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Formulir Pengiriman -->
            <div class="lg:col-span-2 bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Formulir Pembayaran</h2>
                <form action="{{ route('payment.process') }}" method="POST" class="space-y-8" id="payment-form">
                    @csrf
                    <input type="hidden" name="items" value="{{ request()->query('items') }}">
                    <!-- Input Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="name" class="block text-lg text-gray-400 font-pixelify">Nama</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                required
                                class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg"
                                value="{{ session('userData')['fullname'] ?? $userData['fullname'] ?? '' }}"
                                x-model="name">
                        </div>
                        <div>
                            <label for="phone" class="block text-lg text-gray-400 font-pixelify">Nomor Handphone</label>
                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                required
                                class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg"
                                value="{{ session('userData')['phoneNumber'] ?? $userData['phoneNumber'] ?? '' }}"
                                x-model="phone"
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
                            class="mt-2 block w-full rounded-md bg-neutral-900 border border-gray-700 shadow-sm focus:ring-yellow-400 focus:border-yellow-400 text-gray-200 px-6 py-4 text-lg"
                            x-model="alamat">{{ session('userData')['address'] ?? $userData['address'] ?? '' }}</textarea>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Produk -->
            <div class="bg-neutral-800 rounded-lg shadow p-8 text-gray-300">
                <h2 class="text-2xl font-bold mb-8 text-yellow-400">Ringkasan Produk</h2>
                <div class="space-y-6">
                    @foreach($selectedItems as $item)
                        <div class="flex justify-between items-center text-lg">
                            <div class="flex items-center">
                                <img src="{{ 'https://virtual-realm.my.id' . $item['image_url'] }}"
                                     alt="{{ $item['product_name'] }}"
                                     class="w-12 h-12 object-cover rounded-md mr-4"
                                     onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                                <span>{{ $item['product_name'] }}</span>
                            </div>
                            <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
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
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-700 mt-4"></div>
                <!-- Biaya Pengiriman -->
                <div class="flex justify-between items-center text-lg mt-4">
                    <span>Biaya Pengiriman</span>
                    <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-700 mt-4"></div>
                <!-- Total Pembayaran -->
                <div class="flex justify-between items-center text-xl font-bold mt-4">
                    <span>Total Pembayaran</span>
                    <span class="text-yellow-500">Rp {{ number_format($totalPrice + $shippingCost, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-700 mt-6"></div>
            </div>

            <!-- Tombol Buat Pesanan -->
            <div x-data="{ loading: false, formValid: true, name: '', phone: '', alamat: '' }" class="mt-8 flex justify-center">
                <button type="submit"
                        form="payment-form"
                        :disabled="loading || !name || !phone || !alamat"
                        x-bind:class="{'bg-gray-400 cursor-not-allowed': loading || !name || !phone || !alamat, 'bg-yellow-500': !loading}"
                        @click="loading = true"
                        class="text-red-800 rounded-md py-2 px-6 text-lg hover:bg-yellow-400 shadow-lg transform hover:scale-105 transition-all font-pixelify">
                    <span x-show="!loading">Buat Pesanan</span>
                    <span x-show="loading">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
</x-layout>
