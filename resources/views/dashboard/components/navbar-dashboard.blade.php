<!-- Navbar -->
<nav class="bg-gray-800 sticky top-0 z-50 p-4 shadow-md">
    <div class="flex items-center justify-between">
        <a href="#" class="text-white text-lg font-semibold">Dashboard</a>

        <!-- Mobile Toggle Button -->
        <button id="searchToggle" class="md:hidden text-white" onclick="toggleSearch()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        <!-- Search Input -->
        <input id="searchInput"
            class="hidden md:block w-full max-w-md mx-4 px-3 py-2 rounded bg-gray-700 text-white placeholder-gray-400"
            type="text" placeholder="Search" aria-label="Search">
        </input>
        <div>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit"
                    class="block px-4 py-2 text-sm text-gray-100 hover:bg-gray-700 border rounded">Log out</button>
            </form>
        </div>
    </div>
</nav>

<!-- JavaScript for Search Toggle -->
<script>
    function toggleSearch() {
        const searchInput = document.getElementById('searchInput');
        searchInput.classList.toggle('hidden');
        searchInput.focus();
    }
</script>
