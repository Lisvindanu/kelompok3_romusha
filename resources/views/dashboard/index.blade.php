<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Selamat Datang Kembali, {{ $userData['username'] }}</h1>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Daftar Kategori</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">No</th>
                        <th class="py-2 px-4 border-b text-left">Nama Kategori</th>
                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $index => $category)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-b">{{ $category['name'] }}</td>
                            <td class="py-2 px-4 border-b">
                                <!-- Tombol Update yang membuka Modal -->
                                <button onclick="openEditCategoryModal({{ $category['id'] }}, '{{ $category['name'] }}')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ubah</button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Formulir untuk Menambah Kategori -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold">Tambah Kategori Baru</h2>
                <form action="{{ route('categories.addCategories') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" id="category_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Kategori</button>
                </form>
            </div>

            <!-- Tabel Daftar Genre -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Daftar Genre</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">No</th>
                        <th class="py-2 px-4 border-b text-left">Nama Genre</th>
                        <th class="py-2 px-4 border-b text-left">Kategori</th>
                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($genres as $index => $genre)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border-b">{{ $genre['name'] }}</td>
                            <td class="py-2 px-4 border-b">{{ $genre['category']['name'] }}</td>
                            <td class="py-2 px-4 border-b">
                                <button onclick="openEditGenreModal({{ $genre['id'] }}, '{{ $genre['name'] }}', {{ $genre['category']['id'] }})" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ubah</button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Formulir untuk Menambah Genre -->
{{--            <div class="mb-4">--}}
{{--                <h2 class="text-xl font-semibold">Tambah Genre Baru</h2>--}}
{{--                <form action="{{ route('genres.addGenres') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <div class="mb-4">--}}
{{--                        <label for="genre_name" class="block text-sm font-medium text-gray-700">Nama Genre</label>--}}
{{--                        <input type="text" id="genre_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">--}}
{{--                    </div>--}}
{{--                    <div class="mb-4">--}}
{{--                        <label for="category_id" class="block text-sm font-medium text-gray-700">Pilih Kategori</label>--}}
{{--                        <select id="category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">--}}
{{--                            @if($categories->isNotEmpty())--}}
{{--                                @foreach($categories as $category)--}}
{{--                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>--}}
{{--                                @endforeach--}}
{{--                            @else--}}
{{--                                <option value="">No categories available</option>--}}
{{--                            @endif--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Genre</button>--}}
{{--                </form>--}}

{{--            </div>--}}

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Tambah Genre Baru</h2>
                <form action="{{ route('genres.addGenres') }}" method="POST" onsubmit="logFormData(event)">
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
                                    <option value="{{ is_array($category) ? $category['id'] : $category->id }}">
                                        {{ is_array($category) ? $category['name'] : $category->name }}
                                    </option>

                                @endforeach
                            @else
                                <option value="">No categories available</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Genre</button>
                </form>
            </div>

            <script>
                function logFormData(event) {
                    const form = event.target;
                    const formData = new FormData(form);
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                }
            </script>


        </main>
    </div>

    <!-- Modal untuk Edit Kategori -->
    <div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">Ubah Kategori</h2>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" id="category_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Simpan Perubahan</button>
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md ml-2">Tutup</button>
            </form>
        </div>
    </div>

    <!-- Modal untuk Edit Genre -->
    <div id="editGenreModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-md shadow-md w-1/3">
            <h2 class="text-xl font-semibold mb-4">Ubah Genre</h2>
            <form id="editGenreForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="genre_name" class="block text-sm font-medium text-gray-700">Nama Genre</label>
                    <input type="text" id="genre_name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="genre_category_id" name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Simpan Perubahan</button>
                <button type="button" onclick="closeEditGenreModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md ml-2">Tutup</button>
            </form>
        </div>
    </div>

    <!-- JavaScript untuk Toggle Modal -->
    <script>
        // Function to open the edit modal and fill in the data
        // Fungsi untuk membuka modal edit kategori
        function openEditCategoryModal(id, name) {
            document.getElementById('category_name').value = name;
            document.getElementById('editCategoryForm').action = '/categories/' + id;
            document.getElementById('editCategoryModal').classList.remove('hidden');
        }


        function openEditGenreModal(id, name, categoryId) {
            document.getElementById('genre_name').value = name;
            document.getElementById('genre_category_id').value = categoryId;
            document.getElementById('editGenreForm').action = '/genres/' + id;
            document.getElementById('editGenreModal').classList.remove('hidden');
        }


        // Fungsi untuk menutup modal edit kategori
        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');  // Hide the category modal
        }

        // Fungsi untuk menutup modal edit genre
        function closeEditGenreModal() {
            document.getElementById('editGenreModal').classList.add('hidden');  // Hide the genre modal
        }

    </script>

</x-layout-dashboard>
