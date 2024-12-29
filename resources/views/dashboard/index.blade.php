<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Selamat Datang Kembali, {{ $userData['username'] }}</h1>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Box Produk -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-tv fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Produk</h3>
                    <p class="text-gray-400 text-lg" id="productCount">Loading...</p>
                    <a href="/dashboard/products" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <!-- Box Genre -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Genre</h3>
                    <p class="text-gray-400 text-lg" id="genreCount">Loading...</p>
                    <a href="{{ route('dashboard.genre-game') }}" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <!-- Box Kategori -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Kategori</h3>
                    <p class="text-gray-400 text-lg" id="categoryCount">Loading...</p>
                    <a href="/categories/index" class="text-blue-500 hover:text-blue-400 no-underline">Lihat Detail</a>
                </div>
            </div>
        </main>
    </div>

    <script>
        const API_BASE_URL = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api';
        const API_HEADERS = {
            'X-Api-Key': 'secret',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        // Function to fetch count for any entity
        async function fetchCount(endpoint) {
            try {
                const response = await fetch(`${API_BASE_URL}/${endpoint}/count`, {
                    method: 'GET',
                    headers: API_HEADERS,
                    mode: 'cors'
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                return data.status === 'success' ? data.data : 0;
            } catch (error) {
                console.error(`Error fetching ${endpoint} count:`, error);
                return 'Error';
            }
        }

        // Function to update count with animation
        function updateCount(elementId, count, suffix) {
            const element = document.getElementById(elementId);
            if (!element) return;

            if (count === 'Error') {
                element.textContent = 'Error loading count';
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

        // Function to fetch all counts
        async function fetchAllCounts() {
            // Fetch all counts in parallel
            const [products, genres, categories] = await Promise.all([
                fetchCount('products'),
                fetchCount('genres'),
                fetchCount('categories')
            ]);

            // Update UI with animations
            updateCount('productCount', products, 'Produk');
            updateCount('genreCount', genres, 'Genre');
            updateCount('categoryCount', categories, 'Kategori');
        }

        // Call fetchAllCounts when the page loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fetchAllCounts);
        } else {
            fetchAllCounts();
        }
    </script>
</x-layout-dashboard>
