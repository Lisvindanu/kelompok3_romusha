<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Selamat Datang Kembali, {{ $userData['username'] }}</h1>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Product Box -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-tv fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Produk</h3>
                    <p class="text-gray-400 text-lg" id="productCount">Loading...</p>
                    <a href="/dashboard/products" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <!-- Genre Box -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Genre</h3>
                    <p class="text-gray-400 text-lg" id="genreCount">Loading...</p>
                    <a href="{{ route('dashboard.genre-game') }}"
                        class="text-blue-500 hover:text-blue-400 no-underline">Lihat Detail</a>
                </div>

                <!-- Category Box -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Kategori</h3>
                    <p class="text-gray-400 text-lg" id="categoryCount">Loading...</p>
                    <a href="/categories/index" class="text-blue-500 hover:text-blue-400 no-underline">Lihat Detail</a>
                </div>

                <!-- Transaction Box -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-receipt fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Transaksi</h3>
                    <p class="text-gray-400 text-lg" id="transactionCount">Loading...</p>
                    <a href="/dashboard/transactions" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <h3 class="text-gray-200 text-xl font-bold mb-4">Unduh Laporan Transaksi</h3>
                    <a href="{{ route('generateTransactionReport') }}" class="text-white bg-blue-500 hover:bg-blue-400 py-2 px-4 rounded">Unduh PDF</a>
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const API_CONFIG = {
                BASE_URL: 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api',
                HEADERS: {
                    'X-Api-Key': 'secret',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };

            async function fetchCount(endpoint) {
                try {
                    const response = await fetch(`${API_CONFIG.BASE_URL}/${endpoint}/count`, {
                        method: 'GET',
                        headers: API_CONFIG.HEADERS,
                        mode: 'cors'
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    return data.code === 200 && data.status === 'success' ? data.data : 0;
                } catch (error) {
                    console.error(`Error fetching ${endpoint} count:`, error);
                    return 'Error';
                }
            }

            function updateCount(elementId, count, suffix) {
                const element = document.getElementById(elementId);
                if (!element) return;

                if (count === 'Error') {
                    element.textContent = 'Error memuat data';
                    return;
                }

                let currentCount = 0;
                const duration = 1000;
                const interval = 50;
                const steps = duration / interval;
                const increment = count / steps;

                const counter = setInterval(() => {
                    currentCount += increment;
                    if (currentCount >= count) {
                        currentCount = count;
                        clearInterval(counter);
                    }
                    element.textContent = `${Math.floor(currentCount)} ${suffix}`;
                }, interval);
            }

            async function fetchAllCounts() {
                try {
                    const counts = await Promise.all([
                        fetchCount('products'),
                        fetchCount('genres'),
                        fetchCount('categories')
                    ]);

                    updateCount('productCount', counts[0], 'Produk');
                    updateCount('genreCount', counts[1], 'Genre');
                    updateCount('categoryCount', counts[2], 'Kategori');
                } catch (error) {
                    console.error('Error fetching counts:', error);
                }
            }

            fetchAllCounts();
        });
    </script>
</x-layout-dashboard>
