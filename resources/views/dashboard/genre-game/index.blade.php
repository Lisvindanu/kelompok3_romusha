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

            <!-- Tabel Daftar Genre -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Daftar Genre</h2>
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">No</th>
                            <th class="py-2 px-4 border-b text-left">Nama Genre</th>
                            <th class="py-2 px-4 border-b text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $index => $genre)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b">{{ $genre['name'] }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="openEditGenreModal({{ $genre['id'] }}, '{{ $genre['name'] }}')"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-md">Update</button>
                                    <form action="{{ route('genres.destroy', $genre['id']) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-md ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Tambah Genre Baru</h2>
                <form action="{{ route('genres.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Genre</label>
                        <input type="text" id="name" name="name" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Tambah Genre</button>
                </form>
            </div>

            <!-- Modal Edit Genre -->
            <div id="editGenreModal"
                class="hidden fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h3 class="text-xl font-semibold mb-4">Edit Genre</h3>

                    <form action="" method="POST" id="editGenreForm">
                        @csrf
                        @method('PUT') <!-- Pastikan ini PUT untuk pembaruan -->
                        <div class="mb-4">
                            <label for="edit_name" class="block text-sm font-medium text-gray-700">Nama Genre</label>
                            <input type="text" id="edit_name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Genre</button>
                    </form>

                    <button onclick="closeEditGenreModal()" class="mt-4 text-red-500">Tutup</button>
                </div>
            </div>

            <script>
                // Function to open the edit modal and fill in the data
                function openEditGenreModal(id, name) {
                    document.getElementById('edit_name').value = name;
                    document.getElementById('editGenreForm').action = '/genres/' + id; // Set the action correctly
                    document.getElementById('editGenreModal').classList.remove('hidden');
                }

                function closeEditGenreModal() {
                    document.getElementById('editGenreModal').classList.add('hidden');
                }
            </script>

        </main>
    </div>
</x-layout-dashboard>
