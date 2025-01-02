<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <main class="flex-1 p-6">
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

            <!-- Add Genre Form -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Add New Genre</h2>
                <form action="{{ route('genres.store') }}" method="POST" class="max-w-lg">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Genre Name</label>
                        <input type="text" id="name" name="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>

                    <div class="mb-4">
                        <label for="categoryId" class="block text-sm font-medium text-gray-700">Category ID</label>
                        <input type="number" id="categoryId" name="categoryId" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add Genre
                    </button>
                </form>
            </div>

            <!-- Genres Table -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-4">Genre List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Category ID</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $genre['id'] }}</td>
                                <td class="py-2 px-4 border-b">{{ $genre['name'] }}</td>
                                <td class="py-2 px-4 border-b">{{ $genre['category']['id'] }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="openEditModal({{ json_encode($genre) }})"
                                            class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 mr-2">
                                        Edit
                                    </button>
                                    <form action="{{ route('genres.destroy', $genre['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                                                onclick="return confirm('Are you sure you want to delete this genre?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 flex justify-between items-center">
                    <div>
                        <label for="size" class="text-sm">Items per page:</label>
                        <select id="size" onchange="changePageSize(this.value)"
                                class="ml-2 border rounded-md px-2 py-1">
                            <option value="10" {{ request('size') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('size') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('size') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <div class="flex space-x-2">
                        <a href="?page={{ max(0, request('page', 0) - 1) }}&size={{ request('size', 10) }}"
                           class="px-3 py-1 bg-gray-200 rounded-md {{ request('page', 0) == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                            Previous
                        </a>
                        <span class="px-3 py-1">Page {{ request('page', 0) + 1 }}</span>
                        <a href="?page={{ request('page', 0) + 1 }}&size={{ request('size', 10) }}"
                           class="px-3 py-1 bg-gray-200 rounded-md">
                            Next
                        </a>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-white p-6 rounded-lg shadow-xl w-96">
                        <h3 class="text-lg font-semibold mb-4">Edit Genre</h3>
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Genre Name</label>
                                <input type="text" name="name" id="editName" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Category ID</label>
                                <input type="number" name="categoryId" id="editCategoryId" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="closeEditModal()"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function changePageSize(size) {
            window.location.href = `?page=0&size=${size}`;
        }

        function openEditModal(genre) {
            document.getElementById('editForm').action = `/genres/${genre.id}`;
            document.getElementById('editName').value = genre.name;
            document.getElementById('editCategoryId').value = genre.category.id;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Auto-hide alerts after 3 seconds
        setTimeout(() => {
            const successAlert = document.getElementById('alertSuccess');
            const errorAlert = document.getElementById('alertError');

            if (successAlert) {
                successAlert.style.display = 'none';
            }
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 3000);
    </script>
</x-layout-dashboard>
