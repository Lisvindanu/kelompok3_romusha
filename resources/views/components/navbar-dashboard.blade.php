<!-- Navbar with Search -->
<nav class="bg-gray-800 sticky top-0 z-50 p-4 shadow-md">
    <div class="flex items-center justify-between">
        <a href="#" class="text-white text-lg font-semibold">Dashboard</a>

        <button id="searchToggle" class="md:hidden text-white" onclick="toggleSearch()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <div class="relative hidden md:block w-full max-w-md mx-4">
            <input id="searchInput" class="w-full px-3 py-2 rounded bg-gray-700 text-white placeholder-gray-400"
                type="text" placeholder="Search..." aria-label="Search">
        </div>

        <div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="block px-4 py-2 text-sm text-gray-100 hover:bg-gray-700 border rounded">
                    Log out
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- JavaScript for Search -->
<script>
    
    let searchTimeout;
    let allItems = {
        products: [],
        categories: [],
        genres: []
    };

    function toggleSearch() {
        const searchInput = document.getElementById('searchInput');
        searchInput.classList.toggle('hidden');
        searchInput.focus();
    }

    async function fetchAllItems() {
        try {
            const [products, categories, genres] = await Promise.all([
                fetch(`${API_BASE_URL}/products`, {
                    headers: API_HEADERS
                }).then(res => res.json()),
                fetch(`${API_BASE_URL}/categories`, {
                    headers: API_HEADERS
                }).then(res => res.json()),
                fetch(`${API_BASE_URL}/genres`, {
                    headers: API_HEADERS
                }).then(res => res.json())
            ]);

            allItems.products = products.data || [];
            allItems.categories = categories.data || [];
            allItems.genres = genres.data || [];

            return true;
        } catch (error) {
            console.error('Error fetching items:', error);
            return false;
        }
    }

    function createSearchResultsContainer() {
        let container = document.getElementById('searchResults');
        if (!container) {
            container = document.createElement('div');
            container.id = 'searchResults';
            container.className =
                'absolute top-full left-0 right-0 mt-1 bg-gray-700 rounded-lg shadow-xl max-h-96 overflow-y-auto z-50';
            const searchWrapper = document.querySelector('.relative');
            if (searchWrapper) {
                searchWrapper.appendChild(container);
            }
        }
        return container;
    }

    function getRouteForType(type, item) {
        switch (type) {
            case 'products':
                return `/dashboard/products/show-product/${item.id}`;
            case 'categories':
                return `/categories/show/${item.id}`;
            case 'genres':
                return `/dashboard/genre-game/show/${item.id}`;
            default:
                return '#';
        }
    }

    function navigateToUrl(url) {
        window.location.href = url;
    }

    function performSearch(searchTerm) {
        if (!searchTerm) {
            const container = document.getElementById('searchResults');
            if (container) container.remove();
            return;
        }

        const searchResults = {
            products: allItems.products.filter(item =>
                item.name.toLowerCase().includes(searchTerm.toLowerCase())),
            categories: allItems.categories.filter(item =>
                item.name.toLowerCase().includes(searchTerm.toLowerCase())),
            genres: allItems.genres.filter(item =>
                item.name.toLowerCase().includes(searchTerm.toLowerCase()))
        };

        displaySearchResults(searchResults);
    }

    function displaySearchResults(results) {
        const container = createSearchResultsContainer();
        let html = '';

        const createSection = (title, items, type) => {
            if (items.length === 0) return '';
            return `
            <div class="p-3">
                <h3 class="text-white font-semibold mb-2">${title}</h3>
                <div class="space-y-2">
                    ${items.map(item => {
                        const url = getRouteForType(type, item);
                        return `
                            <div 
                                class="block p-2 hover:bg-gray-600 rounded text-gray-200 cursor-pointer"
                                onclick="navigateToUrl('${url}')"
                            >
                                <span class="flex items-center">
                                    ${item.name}
                                    ${type === 'genres' && item.category ? `
                                        <span class="ml-2 text-sm text-gray-400">(${item.category.name})</span>
                                    ` : ''}
                                    ${type === 'products' ? `
                                        <span class="ml-2 text-sm text-gray-400">(${item.type || 'product'})</span>
                                    ` : ''}
                                </span>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
        };

        html += createSection('Products', results.products, 'products');
        html += createSection('Categories', results.categories, 'categories');
        html += createSection('Genres', results.genres, 'genres');

        if (html === '') {
            html = '<div class="p-4 text-gray-400">No results found</div>';
        }

        container.innerHTML = html;
    }

    async function initializeSearch() {
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) return;

        await fetchAllItems();

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(e.target.value.trim());
            }, 300);
        });

        document.addEventListener('click', (e) => {
            const searchResults = document.getElementById('searchResults');
            const searchInput = document.getElementById('searchInput');

            if (searchResults && !searchResults.contains(e.target) && e.target !== searchInput) {
                searchResults.remove();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeSearch);
    } else {
        initializeSearch();
    }
</script>
