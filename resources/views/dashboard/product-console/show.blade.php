<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <!-- Header -->
            <header class="mb-4 lg:mb-6">
                <div class="flex flex-wrap items-center space-x-4 mt-4">
                    <a href="/dashboard/product-console"
                        class="text-blue-600 hover:text-blue-800 font-semibold flex items-center space-x-1">
                        <span class="text-sm">&laquo;</span>
                        <span>Back</span>
                    </a>

                    <!-- Edit Button -->
                    <a href="/dashboard/edit-product-console"
                        class="text-yellow-500 hover:text-yellow-700 flex items-center">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Edit <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                    </a>

                    <!-- Delete Button -->
                    <form action="#" method="post" class="inline" {{-- id="deleteForm{{ $post->id }}">--}
                        @method('delete')
                        @csrf
                        <button type="button" {{-- onclick="showDeleteModal({{ $post->id }})" --}}
                        class="text-red-500 hover:text-red-700 flex items-center">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Delete <i class="fa-regular fa-circle-xmark"></i>
                        </span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Product Details -->
            <section class="bg-gray-100 flex items-center justify-center py-8">
                <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden rounded-lg group">
                            <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="PlayStation 5">
                        </div>

                        <!-- Product Information -->
                        <div class="flex flex-col">
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">PlayStation 5</h1>
                            <p class="text-sm text-gray-600 italic mb-6">
                                PlayStation 5 adalah konsol generasi terbaru dari Sony yang menawarkan performa luar
                                biasa
                                dengan prosesor ultra cepat, grafis memukau, dan fitur SSD yang revolusioner.
                            </p>
                            <p class="text-xl font-semibold text-blue-500 mb-4">Rp 7.500.000</p>
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Stok:</strong> 10 unit
                            </p>
                            <p class="text-sm text-gray-600 mb-6">
                                <strong>Kategori:</strong> Console, Gaming
                            </p>
                        </div>
                    </div>

                    <!-- Product Specifications -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Spesifikasi</h2>
                        <ul class="text-sm text-gray-600 list-disc ml-6 space-y-2">
                            <li>Prosesor: AMD Ryzen Zen 2</li>
                            <li>GPU: AMD RDNA 2</li>
                            <li>RAM: 16GB GDDR6</li>
                            <li>Storage: 825GB SSD</li>
                            <li>Resolusi: Hingga 4K</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow-lg">
                    <h2 class="text-lg font-semibold">Konfirmasi Penghapusan</h2>
                    <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button onclick="hideDeleteModal()"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                        <button id="confirmDeleteButton"
                            class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded">Hapus</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for Search -->
    <script>
        const API_BASE_URL = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api';
        const API_HEADERS = {
            'X-Api-Key': 'secret',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        };

        // Toggle search on mobile
        function toggleSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.classList.toggle('hidden');
            searchInput.focus();
        }

        // Global variables for search
        let searchTimeout;
        let allItems = {
            products: [],
            genres: [],
            categories: []
        };

        // Function to fetch all items
        async function fetchAllItems() {
            try {
                const [products, genres, categories] = await Promise.all([
                    fetch(`${API_BASE_URL}/products`, {
                        headers: API_HEADERS
                    }).then(res => res.json()),
                    fetch(`${API_BASE_URL}/genres`, {
                        headers: API_HEADERS
                    }).then(res => res.json()),
                    fetch(`${API_BASE_URL}/categories`, {
                        headers: API_HEADERS
                    }).then(res => res.json())
                ]);

                allItems.products = products.data || [];
                allItems.genres = genres.data || [];
                allItems.categories = categories.data || [];

                return true;
            } catch (error) {
                console.error('Error fetching items:', error);
                return false;
            }
        }

        // Function to create search results container
        function createSearchResultsContainer() {
            let container = document.getElementById('searchResults');
            if (!container) {
                container = document.createElement('div');
                container.id = 'searchResults';
                container.className =
                    'absolute top-full left-0 right-0 mt-1 bg-gray-700 rounded-lg shadow-xl max-h-96 overflow-y-auto z-50';
                document.querySelector('.max-w-md').appendChild(container);
            }
            return container;
        }

        // Function to get correct route for each type
        function getRouteForType(type, item) {
            switch (type) {
                case 'products':
                    return `/dashboard/products/${item.id}`;
                case 'genres':
                    return `/dashboard/genre-game/${item.id}`;
                case 'categories':
                    return `/categories/index/${item.id}`;
                default:
                    return '#';
            }
        }

        // Function to perform search
        function performSearch(searchTerm) {
            if (!searchTerm) {
                const container = document.getElementById('searchResults');
                if (container) container.remove();
                return;
            }

            const searchResults = {
                products: allItems.products.filter(item =>
                    item.name.toLowerCase().includes(searchTerm.toLowerCase())),
                genres: allItems.genres.filter(item =>
                    item.name.toLowerCase().includes(searchTerm.toLowerCase())),
                categories: allItems.categories.filter(item =>
                    item.name.toLowerCase().includes(searchTerm.toLowerCase()))
            };

            displaySearchResults(searchResults);
        }

        // Function to display search results
        function displaySearchResults(results) {
            const container = createSearchResultsContainer();

            let html = '';

            // Helper function to create section HTML
            const createSection = (title, items, type) => {
                if (items.length === 0) return '';
                return `
                <div class="p-3">
                    <h3 class="text-white font-semibold mb-2">${title}</h3>
                    <div class="space-y-2">
                        ${items.map(item => `
                                <a href="${getRouteForType(type, item)}" 
                                   class="block p-2 hover:bg-gray-600 rounded text-gray-200">
                                    ${item.name}
                                </a>
                            `).join('')}
                    </div>
                </div>
            `;
            };

            // Create sections for each type
            html += createSection('Products', results.products, 'products');
            html += createSection('Genres', results.genres, 'genres');
            html += createSection('Categories', results.categories, 'categories');

            // Show no results message if nothing found
            if (html === '') {
                html = '<div class="p-4 text-gray-400">No results found</div>';
            }

            container.innerHTML = html;
        }

        // Initialize search functionality
        async function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            await fetchAllItems();

            // Add event listener for search input
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch(e.target.value.trim());
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', (e) => {
                const searchResults = document.getElementById('searchResults');
                const searchInput = document.getElementById('searchInput');

                if (searchResults && !searchResults.contains(e.target) && e.target !== searchInput) {
                    searchResults.remove();
                }
            });
        }

        // Start search when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeSearch);
        } else {
            initializeSearch();
        }
    </script>

</x-layout-dashboard>
