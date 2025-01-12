<nav class="bg-neutral-800 fixed top-0 left-0 w-full z-50" x-data="{ isOpen: false, isSearchOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo and Desktop Navigation -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10" src="{{ asset('storage/img/logo.png') }}" alt="RetroGameHub">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
                        <x-nav-link href="/games" :active="request()->is('games')">Game</x-nav-link>
                        <x-nav-link href="/consoles" :active="request()->is('consoles')">Console</x-nav-link>
                        <x-nav-link href="/ewallet" :active="request()->is('ewallet')">E-Wallet</x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Desktop Search -->
            <div x-show="isSearchOpen" @click.away="isSearchOpen = false"
                class="flex flex-col items-center hidden md:block absolute left-1/2 transform -translate-x-1/2 w-96 md:w-96 lg:w-1/3 xl:w-1/4 ml-28 rounded-md bg-gray-800 p-2 z-40">
                <div class="relative flex items-center w-full max-w-md mx-auto">
                    <input id="searchInputHome" type="text" placeholder="Search products..."
                        class="w-full px-4 py-2 rounded-md text-gray-900 bg-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        autocomplete="off">
                    <div id="searchResultsHome"
                        class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-lg z-50 max-h-60 overflow-y-auto hidden">
                        <!-- Desktop search results will be injected here -->
                    </div>
                </div>
            </div>

            <!-- Desktop Navigation Icons -->
            <div class="flex items-center space-x-4 md:space-x-8">
                <div class="relative flex items-center hidden md:block">
                    <button @click="isSearchOpen = !isSearchOpen"
                        class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>

                <a href="/cart" class="text-gray-400 hover:text-white focus:outline-none relative hidden md:block">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span
                        class="absolute -top-1 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                </a>

                <!-- Desktop User Profile -->
                <div class="relative hidden md:block" x-data="{ isProfileOpen: false }">
                    @if (isset($user))
                        <button type="button" @click="isProfileOpen = !isProfileOpen"
                                class="flex items-center space-x-2 rounded-md bg-neutral-800 px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-yellow-500 focus:outline-none">
                            <!-- Profile Photo -->
                            @if(str_contains($user['imageUrl'], 'googleusercontent'))
                                {{-- Login dengan Google --}}
                                <img src="{{ $user['imageUrl'] }}"
                                     alt="{{ $user['fullname'] ?? $user['username'] }}"
                                     class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                                />
                            @elseif(!empty($user['imageUrl']))
                                {{-- Login biasa --}}
                                <img src="{{ 'https://virtual-realm.my.id' . $user['imageUrl'] }}"
                                     alt="{{ $user['fullname'] ?? $user['username'] }}"
                                     class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                                />
                            @else
                                {{-- Fallback ke inisial nama --}}
                                <div class="h-8 w-8 rounded-full bg-neutral-700 flex items-center justify-center border border-yellow-400">
        <span class="text-yellow-400 text-sm font-bold">
            {{ substr($user['fullname'] ?? $user['username'], 0, 1) }}
        </span>
                                </div>
                            @endif

                            <span>{{ $user['fullname'] ?? $user['username'] }}</span>
                            <i class="fa-solid fa-chevron-down text-sm"></i>
                        </button>

                        <div x-show="isProfileOpen" @click.away="isProfileOpen = false" x-transition
                             class="absolute right-0 mt-2 w-56 origin-top-right rounded-lg bg-neutral-800 shadow-md ring-1 ring-black ring-opacity-10 z-40">
                            <!-- Profile Info -->
                            <div class="px-4 py-3 border-b border-neutral-700">
                                <div class="flex items-center space-x-3">
                                    @if(str_contains($user['imageUrl'], 'googleusercontent'))
                                        {{-- Login dengan Google --}}
                                        <img src="{{ $user['imageUrl'] }}"
                                             alt="{{ $user['fullname'] ?? $user['username'] }}"
                                             class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                                        />
                                    @elseif(!empty($user['imageUrl']))
                                        {{-- Login biasa --}}
                                        <img src="{{ 'https://virtual-realm.my.id' . $user['imageUrl'] }}"
                                             alt="{{ $user['fullname'] ?? $user['username'] }}"
                                             class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                                        />
                                    @else
                                        {{-- Fallback ke inisial nama --}}
                                        <div class="h-8 w-8 rounded-full bg-neutral-700 flex items-center justify-center border border-yellow-400">
        <span class="text-yellow-400 text-sm font-bold">
            {{ substr($user['fullname'] ?? $user['username'], 0, 1) }}
        </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-gray-200 font-medium">{{ $user['fullname'] ?? $user['username'] }}</p>
                                        <p class="text-xs text-gray-400">{{ $user['email'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <a href="/profile-users"
                               class="block px-4 py-3 text-sm font-semibold text-gray-50 hover:bg-yellow-500 hover:text-neutral-900 transition-all">
                                My Account
                            </a>
                            <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit"
                                        class="block w-full px-4 py-3 text-sm font-semibold text-gray-50 hover:bg-yellow-500 hover:text-neutral-900 transition-all rounded-b-lg text-left">
                                    Log out
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="/login"
                           class="px-4 py-2 text-sm bg-yellow-400 text-red-700 hover:bg-yellow-500 hover:text-white rounded-md">
                            Log in
                        </a>
                    @endif
                </div>


            </div>

{{--            <!-- Mobile Menu and Search -->--}}
{{--            <div class="-mr-2 flex md:hidden">--}}
{{--                <!-- Mobile Search -->--}}
{{--                <div x-show="isSearchOpen" @click.away="isSearchOpen = false"--}}
{{--                    class="flex items-center absolute left-1/2 transform -translate-x-1/2 mt-14 w-72 rounded-md bg-gray-800 p-2 ring-1 ring-black ring-opacity-5 z-40">--}}
{{--                    <div class="relative w-full">--}}
{{--                        <input id="searchInputMobile" type="text" placeholder="Search products..."--}}
{{--                            class="w-full px-4 py-2 rounded-md text-gray-900 bg-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500"--}}
{{--                            autocomplete="off">--}}
{{--                        <div id="searchResultsMobile"--}}
{{--                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-lg z-50 max-h-[80vh] overflow-y-auto hidden">--}}
{{--                            <!-- Mobile search results will be injected here -->--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="relative flex items-center mr-3">--}}
{{--                    <button @click="isSearchOpen = !isSearchOpen"--}}
{{--                        class="text-gray-400 hover:text-white focus:outline-none">--}}
{{--                        <i class="fas fa-search text-lg"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}

{{--                <a href="/cart"--}}
{{--                    class="text-gray-400 hover:text-white focus:outline-none relative flex items-center mr-3">--}}
{{--                    <i class="fas fa-shopping-cart text-lg"></i>--}}
{{--                    <span--}}
{{--                        class="absolute -top-1 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>--}}
{{--                </a>--}}

{{--                <!-- Mobile Menu Button -->--}}
{{--                <button type="button" @click="isOpen = !isOpen"--}}
{{--                    class="inline-flex items-center justify-center rounded-md bg-yellow-400 p-2 text-red-700 hover:bg-yellow-500 hover:text-white focus:outline-none">--}}
{{--                    <span class="sr-only">Open main menu</span>--}}
{{--                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"--}}
{{--                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                            d="M4 6h16M4 12h16M4 18h16"></path>--}}
{{--                    </svg>--}}
{{--                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"--}}
{{--                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">--}}
{{--                        </path>--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Mobile Navigation Menu -->--}}
{{--    <div x-show="isOpen" class="md:hidden">--}}
{{--        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">--}}
{{--            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>--}}
{{--            <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>--}}
{{--            <x-nav-link href="/games" :active="request()->is('games')">Game</x-nav-link>--}}
{{--            <x-nav-link href="/consoles" :active="request()->is('consoles')">Console</x-nav-link>--}}
{{--            <x-nav-link href="/ewallet" :active="request()->is('ewallet')">E-Wallet</x-nav-link>--}}
{{--        </div>--}}
{{--        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">--}}
{{--            @auth--}}
{{--                <a href="/dashboard"--}}
{{--                    class="block rounded-full border-2 border-yellow-400 px-6 py-2 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">My--}}
{{--                    Dashboard</a>--}}
{{--                <form action="{{ route('logout') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button type="submit"--}}
{{--                        class="block w-full rounded-full border-2 border-yellow-400 px-6 py-2 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">Log--}}
{{--                        out</button>--}}
{{--                </form>--}}
{{--            @endauth--}}
{{--            @guest--}}
{{--                <a href="/login"--}}
{{--                    class="block rounded-full border-2 border-yellow-400 px-6 py-2 text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all">Log--}}
{{--                    in</a>--}}
{{--            @endguest--}}
{{--        </div>--}}
{{--    </div>--}}

            <!-- Mobile Menu and Search -->
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile Search -->
                <div x-show="isSearchOpen" @click.away="isSearchOpen = false"
                     class="flex items-center absolute left-1/2 transform -translate-x-1/2 mt-14 w-72 rounded-md bg-gray-800 p-2 ring-1 ring-black ring-opacity-5 z-40">
                    <div class="relative w-full">
                        <input id="searchInputMobile" type="text" placeholder="Search products..."
                               class="w-full px-4 py-2 rounded-md text-gray-900 bg-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                               autocomplete="off">
                        <div id="searchResultsMobile"
                             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-lg z-50 max-h-[80vh] overflow-y-auto hidden">
                            <!-- Mobile search results will be injected here -->
                        </div>
                    </div>
                </div>

                <div class="relative flex items-center mr-3">
                    <button @click="isSearchOpen = !isSearchOpen"
                            class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>

                <a href="/cart"
                   class="text-gray-400 hover:text-white focus:outline-none relative flex items-center mr-3">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span
                        class="absolute -top-1 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" @click="isOpen = !isOpen"
                        class="inline-flex items-center justify-center rounded-md bg-yellow-400 p-2 text-red-700 hover:bg-yellow-500 hover:text-white focus:outline-none">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="isOpen" class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
            <x-nav-link href="/games" :active="request()->is('games')">Game</x-nav-link>
            <x-nav-link href="/consoles" :active="request()->is('consoles')">Console</x-nav-link>
            <x-nav-link href="/ewallet" :active="request()->is('ewallet')">E-Wallet</x-nav-link>
        </div>
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            @if (isset($user))
                <div class="flex items-center space-x-3 p-3">
                    @if(str_contains($user['imageUrl'], 'googleusercontent'))
                        <img src="{{ $user['imageUrl'] }}"
                             alt="{{ $user['fullname'] ?? $user['username'] }}"
                             class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                        />
                    @elseif(!empty($user['imageUrl']))
                        <img src="{{ 'https://virtual-realm.my.id' . $user['imageUrl'] }}"
                             alt="{{ $user['fullname'] ?? $user['username'] }}"
                             class="h-8 w-8 rounded-full object-cover border border-yellow-400"
                        />
                    @else
                        <div class="h-8 w-8 rounded-full bg-neutral-700 flex items-center justify-center border border-yellow-400">
                        <span class="text-yellow-400 text-sm font-bold">
                            {{ substr($user['fullname'] ?? $user['username'], 0, 1) }}
                        </span>
                        </div>
                    @endif
                    <div class="text-gray-200">
                        <p class="font-medium">{{ $user['fullname'] ?? $user['username'] }}</p>
                        <p class="text-xs text-gray-400">{{ $user['email'] }}</p>
                    </div>
                </div>
                <a href="/profile-users"
                   class="block w-full rounded-md px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-yellow-500 hover:text-neutral-900 transition-all">
                    My Account
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="block w-full rounded-md px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-yellow-500 hover:text-neutral-900 transition-all">
                        Log out
                    </button>
                </form>
            @else
                <a href="/login"
                   class="block w-full rounded-md px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-yellow-500 hover:text-neutral-900 transition-all">
                    Log in
                </a>
            @endif
        </div>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInputHome = document.getElementById('searchInputHome');
        const searchResultsHome = document.getElementById('searchResultsHome');
        let searchTimeout = null;
        let cachedProducts = [];

        async function fetchAllProducts() {
            try {
                const response = await fetch('/api/products', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) throw new Error('Failed to fetch products');
                const data = await response.json();
                cachedProducts = data.data || data;
                return true;
            } catch (error) {
                console.error('Error fetching products:', error);
                return false;
            }
        }

        function getImageUrl(product) {
            if (product.imageUrl) {
                return `https://virtual-realm.my.id${product.imageUrl}`;
            }
            return 'https://virtual-realm.my.id/uploads/images/default-image.jpg';
        }

        function performSearch(query) {
            if (!query) {
                hideResults();
                return;
            }

            const results = cachedProducts.filter(product =>
                product.name.toLowerCase().includes(query.toLowerCase()) ||
                (product.type && product.type.toLowerCase().includes(query.toLowerCase()))
            );

            if (results.length === 0) {
                renderNoResults();
                return;
            }

            const groupedResults = {
                game: results.filter(p => p.type?.toLowerCase() === 'game'),
                console: results.filter(p => p.type?.toLowerCase() === 'console'),
                ewallet: results.filter(p => p.type?.toLowerCase() === 'ewallet'),
                other: results.filter(p => !p.type || !['game', 'console', 'ewallet'].includes(p.type
                    .toLowerCase()))
            };

            renderSearchResults(groupedResults);
        }

        function hideResults() {
            searchResultsHome.innerHTML = '';
            searchResultsHome.classList.add('hidden');
        }

        function renderNoResults() {
            searchResultsHome.innerHTML = `
                <div class="flex items-center justify-center py-4 text-gray-500">
                    <i class="fas fa-search mr-2"></i>
                    <span>No products found</span>
                </div>`;
            searchResultsHome.classList.remove('hidden');
        }

        function renderSearchResults(groupedResults) {
            const sections = [];
            const categories = {
                game: 'Games',
                console: 'Consoles',
                ewallet: 'E-Wallet',
                other: 'Other Products'
            };

            for (const [category, products] of Object.entries(groupedResults)) {
                if (products.length > 0) {
                    sections.push(`
                    <div class="category-section">
                        <div class="px-3 py-2 bg-gray-100 border-b font-semibold text-gray-700">
                            ${categories[category]} (${products.length})
                        </div>
                        ${products.map(product => `
                            <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer transition duration-150 border-b"
                                 onclick="window.location.href='/product/${escapeHtml(product.id)}'">
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                    <img src="${getImageUrl(product)}"
                                         alt="${escapeHtml(product.name)}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <h3 class="text-gray-900 font-medium line-clamp-1">${escapeHtml(product.name)}</h3>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-yellow-500 font-semibold">
                                            Rp ${formatPrice(product.price)}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `);
                }
            }

            searchResultsHome.innerHTML = sections.join('');
            searchResultsHome.classList.remove('hidden');
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(price);
        }

        function escapeHtml(unsafe) {
            return unsafe?.toString().replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]) ?? '';
        }

        if (searchInputHome && searchResultsHome) {
            initSearch();
        }

        async function initSearch() {
            await fetchAllProducts();
            hideResults();

            searchInputHome?.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch(e.target.value.trim());
                }, 300);
            });

            document.addEventListener('click', (e) => {
                if (!searchResultsHome?.contains(e.target) && e.target !== searchInputHome) {
                    hideResults();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    hideResults();
                    searchInputHome?.blur();
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Get both desktop and mobile elements
        const searchInputMobile = document.getElementById('searchInputMobile');
        const searchResultsMobile = document.getElementById('searchResultsMobile');
        let searchTimeout = null;
        let cachedProducts = [];

        // Fetch and cache all products
        async function fetchAllProducts() {
            try {
                const response = await fetch('/api/products', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) throw new Error('Failed to fetch products');
                const data = await response.json();
                cachedProducts = data.data || data;
                return true;
            } catch (error) {
                console.error('Error fetching products:', error);
                return false;
            }
        }

        // Helper function to get image URL
        function getImageUrl(product) {
            if (product.imageUrl) {
                return `https://virtual-realm.my.id${product.imageUrl}`;
            }
            return 'https://virtual-realm.my.id/uploads/images/default-image.jpg';
        }

        // Perform search on cached products
        function performSearch(query, isMobile = false) {
            const resultsContainer = isMobile ? searchResultsMobile : searchResultsHome;

            if (!query) {
                hideResults(isMobile);
                return;
            }

            const results = cachedProducts.filter(product =>
                product.name.toLowerCase().includes(query.toLowerCase()) ||
                (product.type && product.type.toLowerCase().includes(query.toLowerCase()))
            );

            if (results.length === 0) {
                renderNoResults(isMobile);
                return;
            }

            const groupedResults = {
                game: results.filter(p => p.type?.toLowerCase() === 'game'),
                console: results.filter(p => p.type?.toLowerCase() === 'console'),
                ewallet: results.filter(p => p.type?.toLowerCase() === 'ewallet'),
                other: results.filter(p => !p.type || !['game', 'console', 'ewallet'].includes(p.type
                    .toLowerCase()))
            };

            renderSearchResults(groupedResults, isMobile);
        }

        // Hide search results
        function hideResults(isMobile = false) {
            const resultsContainer = isMobile ? searchResultsMobile : searchResultsHome;
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('hidden');
        }

        // Render no results message
        function renderNoResults(isMobile = false) {
            const resultsContainer = isMobile ? searchResultsMobile : searchResultsHome;
            resultsContainer.innerHTML = `
            <div class="flex items-center justify-center py-4 text-gray-500">
                <i class="fas fa-search mr-2"></i>
                <span>No products found</span>
            </div>`;
            resultsContainer.classList.remove('hidden');
        }

        // Render search results
        function renderSearchResults(groupedResults, isMobile = false) {
            const resultsContainer = isMobile ? searchResultsMobile : searchResultsHome;
            const sections = [];
            const categories = {
                game: 'Games',
                console: 'Consoles',
                ewallet: 'E-Wallet',
                other: 'Other Products'
            };

            for (const [category, products] of Object.entries(groupedResults)) {
                if (products.length > 0) {
                    sections.push(`
                    <div class="category-section">
                        <div class="px-3 py-2 bg-gray-100 border-b font-semibold text-gray-700">
                            ${categories[category]} (${products.length})
                        </div>
                        ${products.map(product => `
                            <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer transition duration-150 border-b"
                                 onclick="window.location.href='/product/${escapeHtml(product.id)}'">
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                    <img src="${getImageUrl(product)}"
                                         alt="${escapeHtml(product.name)}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <h3 class="text-gray-900 font-medium line-clamp-1">${escapeHtml(product.name)}</h3>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-yellow-500 font-semibold">
                                            Rp ${formatPrice(product.price)}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `);
                }
            }

            resultsContainer.innerHTML = sections.join('');
            resultsContainer.classList.remove('hidden');
        }

        // Format price helper
        function formatPrice(price) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(price);
        }

        // Escape HTML helper
        function escapeHtml(unsafe) {
            return unsafe?.toString().replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]) ?? '';
        }

        // Initialize search functionality
        async function initSearch() {
            await fetchAllProducts();

            // Mobile search initialization
            if (searchInputMobile && searchResultsMobile) {
                hideResults(true);

                searchInputMobile.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(e.target.value.trim(), true);
                    }, 300);
                });

                document.addEventListener('click', (e) => {
                    if (!searchResultsMobile.contains(e.target) && e.target !== searchInputMobile) {
                        hideResults(true);
                    }
                });
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    hideResults(true);
                    searchInputMobile?.blur();
                }
            });
        }

        // Start the initialization
        initSearch();
    });
</script>
