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
                        <div class="text-red-500 mb-4 font-semibold">
                            {{ $error }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($orders as $order)
                            <div class="bg-neutral-900 rounded-lg shadow-md p-4 flex items-start gap-4" x-data="{ open: false }">
                                <img src="{{ $order['image_url'] ? 'https://virtual-realm.my.id' . $order['image_url'] : 'https://virtual-realm.my.id/uploads/images/default-image.jpg' }}"
                                     alt="{{ $order['product_name'] }}"
                                     onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'"
                                     class="w-16 h-16 rounded-md object-cover border border-gray-600">
                                <div class="flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-200">{{ $order['product_name'] }}</h3>
                                    <p class="text-sm text-gray-400">Jumlah Pesanan: <span class="text-white">{{ $order['quantity'] }}</span> Item</p>
                                    <p class="text-sm text-gray-400">Total: <span class="text-white">Rp {{ number_format($order['price'] * $order['quantity'], 0, ',', '.') }}</span></p>
                                </div>
                                <div class="text-sm text-white px-3 py-1 rounded-md"
                                     style="background-color: {{ $order['status'] === 'completed' ? '#16A34A' : ($order['status'] === 'canceled' ? '#DC2626' : '#FACC15') }}">
                                    {{ ucfirst($order['status']) }}
                                </div>

                                <!-- Button and Modal -->
                                <button @click="open = true" class="text-yellow-400 mt-2 hover:underline">
                                    {{
                                        $order['status'] === 'pending' ? 'Lihat Catatan' :
                                        ($order['status'] === 'canceled' ? 'Lihat Alasan' :
                                        ($order['status'] === 'progress' ? 'Lihat Status' : 'Lihat Rincian'))
                                    }}
                                </button>

                                <!-- Modal -->
                                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" @click.away="open = false">
                                    <div class="bg-neutral-800 rounded-lg p-6 w-96">
                                        <h3 class="text-xl font-semibold text-yellow-400 mb-4">
                                            {{
                                                $order['status'] === 'pending' ? 'Catatan' :
                                                ($order['status'] === 'canceled' ? 'Alasan' :
                                                ($order['status'] === 'progress' ? 'Status Proses' : 'Rincian Pesanan'))
                                            }}
                                        </h3>
                                        <p class="text-gray-300">
                                            {{ $order['reason'] ?? 'Tidak ada informasi tambahan' }}
                                        </p>
                                        <div class="flex justify-end mt-4">
                                            <button @click="open = false" class="bg-yellow-400 text-neutral-900 px-4 py-2 rounded-md">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 mx-auto mb-4 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m0 0l-6-6m6 6H3" />
                                </svg>
                                <p class="text-lg font-semibold">Belum ada pesanan dalam riwayat.</p>
                                <a href="{{ route('home') }}" class="text-yellow-400 hover:underline">
                                    Mulai Belanja
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
</x-layout>
