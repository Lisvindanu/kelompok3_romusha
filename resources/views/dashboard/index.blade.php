<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Selamat Datang Kembali, {{ $userData['username'] }}</h1>
            </div>

            <!-- Formulir untuk Menambah Kategori -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold">Tambah Kategori Baru</h2>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" id="category_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Kategori</button>
                </form>
            </div>

            <!-- Formulir untuk Menambah Genre -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold">Tambah Genre Baru</h2>
                <form action="{{ route('genres.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="genre_name" class="block text-sm font-medium text-gray-700">Nama Genre</label>
                        <input type="text" id="genre_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Pilih Kategori</label>
                        <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @if($categories->isNotEmpty())
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @else
                                <option value="">No categories available</option>
                            @endif


                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Genre</button>
                </form>
            </div>

        </main>
    </div>

    <!-- JavaScript untuk Toggle Sidebar -->
    <script>
        const toggleButton = document.getElementById('toggleButton');
        const sidebar = document.getElementById('sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</x-layout-dashboard>
