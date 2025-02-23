<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            <div class="mb-4">
                <!-- Alert Section -->
                @if (session('success'))
                    <div id="alertSuccess" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="alertError" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

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
                        @forelse($categories as $index => $category)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if (is_array($category) && isset($category['name']))
                                        {{ $category['name'] }}
                                    @elseif(is_string($category))
                                        {{ $category }}
                                    @else
                                        Tidak diketahui
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <button
                                        onclick="openEditCategoryModal({{ $category['id'] ?? 0 }}, '{{ $category['name'] ?? '' }}')"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Ubah</button>
                                    <form action="{{ route('categories.delete', $category['id'] ?? 0) }}" method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 px-4 border-b text-center">Tidak ada kategori yang
                                    tersedia.</td>
                            </tr>
                        @endforelse
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
                        <input type="text" id="category_name" name="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Kategori</button>
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

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal"
        class="hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h3 class="text-xl font-semibold mb-4">Edit Kategori</h3>

            <!-- Pesan Sukses/Gagal -->
            <div id="message" class="mb-4 hidden">
                <p id="successMessage" class="text-green-500"></p>
                <p id="errorMessage" class="text-red-500"></p>
            </div>

            <!-- Form untuk mengedit kategori -->
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT') <!-- Gunakan metode PUT untuk update data -->
                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" id="category_name" name="name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Update
                    Kategori</button>
            </form>
            <button onclick="closeEditCategoryModal()" class="mt-4 text-red-500">Tutup</button>
        </div>
    </div>

    <script>
        // Function to open the edit modal and fill in the data
        function openEditCategoryModal(id, name) {
            document.getElementById('category_name').value = name;
            document.getElementById('editCategoryForm').action = '/categories/' + id;
            document.getElementById('editCategoryModal').classList.remove('hidden');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }
    </script>
</x-layout-dashboard>
