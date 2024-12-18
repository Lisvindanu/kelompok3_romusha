<nav class="bg-gray-800 fixed top-0 left-0 w-full z-50" x-data="{ isOpen: false, isSearchOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo dan Link Navigasi -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-12 w-12" src="{{ asset('storage/img/logo.png') }}" alt="RetroGameHub">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
                        <x-nav-link href="/games" :active="request()->is('games')">Game</x-nav-link>
                        <x-nav-link href="/consoles" :active="request()->is('consoles')">Console</x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Dropdown Search Input -->
            <div x-show="isSearchOpen" @click.away="isSearchOpen = false"
                class="flex items-center hidden md:block absolute left-1/2 transform -translate-x-1/2  w-96 md:w-96 lg:w-1/3 xl:w-1/4 ml-28 rounded-md bg-gray-800 p-2 z-40">
                <input type="text" placeholder="Search..."
                    class="w-full px-4 py-2 rounded-md text-gray-900 focus:outline-none" />
            </div>


            <!-- Profil Pengguna, Search, dan Keranjang -->
            <div class="flex items-center space-x-4 md:space-x-8">
                <!-- Tombol Search dan Input -->
                <div class="relative flex items-center hidden md:block">
                    <button @click="isSearchOpen = !isSearchOpen"
                        class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>

                <!-- Keranjang Icon -->
                <a href="/cart" class="text-gray-400 hover:text-white focus:outline-none relative hidden md:block">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span
                        class="absolute -top-1 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                </a>

                <!-- Profil Pengguna -->
                <div class="relative hidden md:block" x-data="{ isProfileOpen: false }">
                    @auth
                        <button type="button" @click="isProfileOpen = !isProfileOpen"
                            class="flex items-center space-x-2 rounded-md bg-indigo-800 px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-indigo-500 focus:outline-none">
                            <span>Welcome Back, {{ auth()->user()->name }}</span>
                            <i class="fa-solid fa-user text-lg"></i>
                        </button>
                        <div x-show="isProfileOpen" @click.away="isProfileOpen = false" x-transition
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 z-40">
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                                Dashboard</a>
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log out</button>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <a href="/login"
                            class="px-4 py-2 text-sm text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md hidden md:block">Log
                            in</a>
                    @endguest
                </div>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="-mr-2 flex md:hidden">

                <!-- Dropdown Search Input -->
                <div x-show="isSearchOpen" @click.away="isSearchOpen = false"
                    class="flex items-center absolute left-1/2 transform -translate-x-1/2 mt-14 w-72 rounded-md bg-gray-800 p-2 ring-1 ring-black ring-opacity-5 z-40">
                    <input type="text" placeholder="Search..."
                        class="w-full px-4 py-2 rounded-md text-gray-900 focus:outline-none" />
                </div>


                <!-- Tombol Search dan Input -->
                <div class="relative flex items-center mr-3">
                    <button @click="isSearchOpen = !isSearchOpen"
                        class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                </div>

                <!-- Keranjang Icon -->
                <a href="/cart"
                    class="text-gray-400 hover:text-white focus:outline-none relative flex items-center mr-3">
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span
                        class="absolute -top-1 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                </a>
                <button type="button" @click="isOpen = !isOpen"
                    class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none">
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

    <!-- Mobile Menu -->
    <div x-show="isOpen" class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
            <x-nav-link href="/games" :active="request()->is('games')">Game</x-nav-link>
            <x-nav-link href="/consoles" :active="request()->is('consoles')">Console</x-nav-link>
        </div>
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            @auth
                <a href="/dashboard"
                    class="block px-4 py-2 text-sm text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md">My Dashboard</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit"
                        class="block w-full px-4 py-2 text-sm text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md">
                        Log out
                    </button>
                </form>
            @endauth
            @guest
                <a href="/login" class="block px-4 py-2 text-sm text-gray-300 bg-gray-700 hover:bg-gray-600 rounded-md">
                    Log in
                </a>
            @endguest
        </div>
    </div>
</nav>
