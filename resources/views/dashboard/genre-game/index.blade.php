<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Genre Game</h1>
            </div>

            <div class="flex justify-start mb-4">
                <a href="/dashboard/create-genre-game"
                    class="bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 font-semibold px-3 py-1 rounded flex items-center space-x-2 transition-colors duration-200">
                    <span>Create new post</span>
                    <span class="text-sm">&raquo;</span>
                </a>
            </div>

            <div class="my-4">
                <!-- Responsive List for Mobile -->
                <div class="overflow-x-auto bg-white rounded shadow mt-4 md:hidden">
                    <div class="flex flex-col space-y-4">
                        <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                            <div class="flex justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Post One</h2>
                                <span class="text-gray-500 text-sm">Genre A</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <!-- Edit -->
                                <a href="/dashboard/edit-genre-game" class="text-yellow-500 hover:text-yellow-700">
                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        Edit <i class="fa-regular fa-pen-to-square"></i>
                                    </span>
                                </a>
                                <!-- Delete -->
                                <button type="button" onclick="showDeleteModal(1)"
                                    class="text-red-500 hover:text-red-700">
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        Delete <i class="fa-regular fa-circle-xmark"></i>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table for Desktop -->
                <div class="hidden md:block overflow-x-auto bg-white rounded shadow mt-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Genre</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">1</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">Genre A</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center space-x-2">
                                        <a href="#"
                                            class="text-yellow-500 hover:text-yellow-700 flex items-center">
                                            <span
                                                class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                Edit <i class="fa-regular fa-pen-to-square"></i>
                                            </span>
                                        </a>
                                        <button type="button" onclick="showDeleteModal(1)"
                                            class="text-red-500 hover:text-red-700 flex items-center">
                                            <span
                                                class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                Delete <i class="fa-regular fa-circle-xmark"></i>
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded shadow-lg max-w-xs w-full">
                    <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
                    <p class="mb-4">Are you sure you want to delete this post?</p>
                    <div class="flex justify-end space-x-2">
                        <button onclick="hideDeleteModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                        <button id="confirmDeleteButton"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Yes,
                            Delete</button>
                    </div>
                </div>
            </div>
            <script>
                let deleteFormId;

                function showDeleteModal(postId) {
                    deleteFormId = postId;
                    document.getElementById('deleteModal').classList.remove('hidden');
                }

                function hideDeleteModal() {
                    document.getElementById('deleteModal').classList.add('hidden');
                }

                document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    alert('Deleting post ID: ' + deleteFormId);
                    hideDeleteModal();
                });
            </script>
        </main>
</x-layout-dashboard>
