<!-- Sidebar and Main Content -->
<div class="flex">
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" class="md:hidden p-4 text-gray-500 focus:outline-none" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i> <!-- Hamburger Icon -->
    </button>

    <!-- Sidebar -->
    <aside
        class="bg-white w-64 fixed top-0 left-0 h-screen shadow-md transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-40 overflow-y-auto md:mt-0"
        id="sidebar">
        <div class="p-4 mt-16"> <!-- Adjusted for desktop and mobile -->
            <nav class="space-y-2">
                <!-- Dashboard Link -->
                <a href="/dashboard"
                    class="block py-2 px-3 rounded {{ request()->is('dashboard') ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} text-sm font-medium"
                    aria-current="{{ request()->is('dashboard') ? 'page' : false }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>

                <!-- Produk -->
                <a href="/dashboard/product-game"
                    class="block py-2 px-3 rounded {{ request()->is('dashboard/product-game*') ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} text-sm font-medium"
                    aria-current="{{ request()->is('dashboard/product-game*') ? 'page' : false }}">
                    <i class="fas fa-tv"></i> Produk
                </a>

                <!-- Genre -->
                <a href="/dashboard/genre-game"
                    class="block py-2 px-3 rounded {{ request()->is('dashboard/genre-game*') ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} text-sm font-medium"
                    aria-current="{{ request()->is('dashboard/genre-game*') ? 'page' : false }}">
                    <i class="fas fa-layer-group"></i> Genre
                </a>

                <!-- Kategori -->
                <a href="/dashboard/genre-game"
                    class="block py-2 px-3 rounded {{ request()->is('dashboard/genre-game*') ? 'bg-gray-200 text-gray-900' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} text-sm font-medium"
                    aria-current="{{ request()->is('dashboard/genre-game*') ? 'page' : false }}">
                    <i class="fas fa-layer-group"></i> Kategori
                </a>
            </nav>

            <!-- Button to Hide Sidebar -->
            <button class="mt-4 md:hidden p-2 bg-gray-200 text-gray-700 rounded" onclick="toggleSidebar()">
                <span class="text-sm">&laquo;</span>
                <span>Kembali</span>
            </button>
        </div>
    </aside>

    <!-- Main Content with Left Margin on Desktop -->
    <div class="flex-1 p-6 md:ml-64 overflow-auto"> <!-- Adjusted for desktop view -->
        <!-- Your main content here -->
    </div>
</div>

<!-- JavaScript for Sidebar Toggle -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script>
