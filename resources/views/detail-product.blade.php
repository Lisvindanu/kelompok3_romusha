<x-layout>
    <x-navbar></x-navbar>
    <section class="bg-neutral-900 min-h-screen flex items-center justify-center py-16 mt-7">
        <div class="bg-neutral-800 rounded-lg shadow-lg max-w-4xl w-full p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-yellow-400 mb-4">{{ $product['name'] }}</h1>
                    <p class="text-sm text-gray-400 italic mb-6">
                        {{ $product['description'] ?? 'Deskripsi produk tidak tersedia.' }}
                    </p>
                    <p class="text-xl font-semibold text-yellow-500 mb-4">Rp
                        {{ number_format($product['price'], 0, ',', '.') }}</p>
                    <div class="flex items-center gap-4">
                        @if (session('user'))
                            <button onclick="buyNow({{ $product['id'] }})" id="buyNowButton"
                                    class="rounded-full bg-yellow-400 py-2 px-6 text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all flex items-center justify-center gap-2">
                                <span id="buyNowText">Beli Sekarang</span>
                                <span id="buyNowLoading" class="hidden">
                                    <svg class="animate-spin h-4 w-4 text-red-700" xmlns="http://www.w3.org/2000/svg"
                                         fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                            <button onclick="addToInventory({{ $product['id'] }})"
                                    class="rounded-full border-2 border-yellow-400 py-2 px-6 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">
                                Tambah ke Keranjang
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                               class="rounded-full bg-yellow-400 py-2 px-6 text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all">
                                Login to Buy
                            </a>
                            <a href="{{ route('login') }}"
                               class="rounded-full border-2 border-yellow-400 py-2 px-6 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">
                                Login to Add to Cart
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Specifications and Video -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <!-- Specifications Section -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-4">Spesifikasi</h2>
                    <div class="text-sm text-gray-400 list-disc ml-6 space-y-2">
                        @if (!empty($product['specifications']))
                            <p>{!! $product['specifications'] !!}</p>
                        @else
                            <p>Spesifikasi tidak tersedia.</p>
                        @endif
                    </div>
                </div>

                <!-- Video Section -->
                @if (isset($product['youtubeUrl']) && !empty($product['youtubeUrl']))
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-400 mb-4">Video Produk</h2>
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe
                                class="w-full h-96 rounded-lg bg-neutral-800"
                                src="https://www.youtube.com/embed/{{ $product['youtubeId'] }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <x-footer></x-footer>

    <!-- Add notification container -->
    <div id="notification"
         class="fixed top-4 right-4 z-50 hidden transform transition-transform duration-300 ease-in-out">
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-lg">
            <div class="flex items-center">
                <div class="py-1">
                    <svg class="h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Memproses Pembelian</p>
                    <p class="text-sm">Mohon tunggu sebentar...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log('Script loaded');

        // Modified buyNow function with loading state
        window.buyNow = function(productId) {
            // Get button elements
            const button = document.getElementById('buyNowButton');
            const buttonText = document.getElementById('buyNowText');
            const buttonLoading = document.getElementById('buyNowLoading');
            const notification = document.getElementById('notification');

            // Disable button and show loading
            button.disabled = true;
            buttonText.textContent = 'Memproses...';
            buttonLoading.classList.remove('hidden');
            notification.classList.remove('hidden');

            // Add slide-in animation
            notification.classList.add('translate-x-0');
            notification.classList.remove('translate-x-full');

            console.log('Buy Now clicked for ID:', productId);

            // Redirect after short delay to show loading state
            setTimeout(() => {
                window.location.href = `/payment?items=${productId}&type=buy_now`;
            }, 1000);
        };

        // Existing addToInventory function
        window.addToInventory = function(productId) {
            console.log('Function called with ID:', productId);

            const data = {
                productId: productId,
                userId: '{{ session('user') }}',
                quantity: 1
            };
            console.log('Sending data:', data);

            fetch('/api/inventory/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data)
            })
                .then(async response => {
                    const text = await response.text();
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Failed to parse JSON:', e);
                        throw new Error('Invalid JSON response');
                    }
                })
                .then(data => {
                    console.log('Parsed data:', data);
                    alert('Produk berhasil ditambahkan ke keranjang!');
                })
                .catch(error => {
                    console.error('Detailed error:', error);
                    alert('Gagal menambahkan produk ke keranjang.');
                });
        }
    </script>
</x-layout>
