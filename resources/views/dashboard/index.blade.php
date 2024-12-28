{{-- @php dd($userData, $categories, $genres); @endphp --}}
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
                    <p class="text-gray-400 text-lg">10 Produk</p>
                    <a href="/dashboard/product-game" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <!-- Box Genre -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Genre</h3>
                    <p class="text-gray-400 text-lg">10 Genre</p>
                    <a href="/dashboard/genre-game" class="text-blue-500 hover:text-blue-400 no-underline">Lihat
                        Detail</a>
                </div>

                <!-- Box Kategori -->
                <div class="bg-gray-800 rounded-lg p-6 flex flex-col items-center justify-between shadow-lg">
                    <i class="fas fa-layer-group fa-5x text-gray-400 mb-4"></i>
                    <h3 class="text-gray-200 text-xl font-bold">Kategori</h3>
                    <p class="text-gray-400 text-lg">10 Genre</p>
                    <a href="/categories/index" class="text-blue-500 hover:text-blue-400 no-underline">Lihat Detail</a>
                </div>
            </div>
        </main>
    </div>

    <script>
        function logFormData(event) {
            event.preventDefault(); // Mencegah pengiriman form
            const form = event.target;
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
        }

        function openEditCategoryModal(id, name) {
            alert(`Edit Kategori: ${name} (ID: ${id})`);
        }

        function openEditGenreModal(id, name, categoryId) {
            alert(`Edit Genre: ${name} (ID: ${id}, Kategori: ${categoryId})`);
        }
    </script>
    </main>

</x-layout-dashboard>
