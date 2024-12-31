<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Account Wrapper -->
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-6 pt-4 pb-16 mt-7">
            <!-- Sidebar -->
            <x-profile-sidebar :activePage="'history'" :userData="$userData" />

            <!-- Main Content -->
            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-pixelify text-yellow-400 mb-4">Riwayat Pesanan</h2>

                    @if(isset($error))
                        <div class="text-red-500 mb-4">{{ $error }}</div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($orders as $order)
                            <div class="bg-neutral-900 rounded-lg shadow-md p-4 flex items-center gap-4">
                                <img src="{{ 'https://virtual-realm.my.id' . $order['image_url'] }}"
                                     alt="{{ $order['product_name'] }}"
                                     onerror="this.src='/api/placeholder/64/64'"
                                     class="w-16 h-16 rounded-md object-cover border border-gray-600">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-200">{{ $order['product_name'] }}</h3>
                                    <p class="text-sm text-gray-400">Jumlah Pesanan: <span class="text-white">{{ $order['quantity'] }}</span> Item</p>
                                    <p class="text-sm text-gray-400">Total: <span class="text-white">Rp {{ number_format($order['price'] * $order['quantity'], 0, ',', '.') }}</span></p>
                                </div>
                                <div class="text-sm text-white px-3 py-1 {{ $order['status'] === 'completed' ? 'bg-green-600' : 'bg-yellow-500' }} rounded-md">
                                    {{ ucfirst($order['status']) }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-gray-400">
                                Belum ada pesanan dalam riwayat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-layout>
