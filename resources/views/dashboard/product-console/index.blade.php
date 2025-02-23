<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Product Console</h1>
            </div>

            {{-- <div class="flex justify-center">
              @if (session('success'))
                  <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded flex items-center mb-4"
                      role="alert">
                      <strong class="font-bold">Success!</strong>
                      <span>{{ session('success') }}</span>
                      <button type="button" class="text-green-700 font-bold ml-2"
                          onclick="this.parentElement.style.display='none';">&times;</button>
                  </div>
              @endif
          </div> --}}

            <div class="flex justify-start mb-4">
                <a href="/dashboard/create-product-console"
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
                                <span class="text-gray-500 text-sm">Category A</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <!-- View -->
                                <a href="/dashboard/show-product-console" class="text-blue-500 hover:text-blue-700">
                                    <span
                                        class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        View <i class="fa-regular fa-eye"></i>
                                    </span>
                                </a>
                                <!-- Edit -->
                                <a href="/dashboard/edit-product-console" class="text-yellow-500 hover:text-yellow-700">
                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        Edit <i class="fa-regular fa-pen-to-square"></i>
                                    </span>
                                </a>
                                <!-- Delete -->
                                <button type="button" onclick="confirmDeleteButton(1)"
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
                                    Name</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th scope="col"
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">1</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">Post One</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">Category A</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center space-x-2">
                                        <a href="/dashboard/show-product-console"
                                            class="text-blue-500 hover:text-blue-700 flex items-center">
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                View <i class="fa-regular fa-eye"></i>
                                            </span>
                                        </a>
                                        <a href="/dashboard/edit-product-console"
                                            class="text-yellow-500 hover:text-yellow-700 flex items-center">
                                            <span
                                                class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                Edit <i class="fa-regular fa-pen-to-square"></i>
                                            </span>
                                        </a>
                                        <button type="button" onclick="confirmDeleteButton(1)"
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
            <div id="deleteModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow-lg">
                    <h2 class="text-lg font-semibold">Konfirmasi Penghapusan</h2>
                    <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button onclick="hideDeleteModal()"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                        <button id="confirmDeleteButton"
                            class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded">Hapus</button>
                    </div>
                </div>
            </div>
            <script>
                document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    fetch(`/dashboard/products/${deleteFormId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                        })
                        .then(response => {
                            if (response.ok) {
                                alert('Produk berhasil dihapus');
                                location.reload(); // Refresh halaman untuk memperbarui daftar produk
                            } else {
                                return response.json().then(data => {
                                    alert(`Gagal menghapus produk: ${data.message}`);
                                });
                            }
                        })
                        .catch(error => {
                            alert('Terjadi kesalahan saat menghapus produk');
                            console.error(error);
                        })
                        .finally(() => {
                            hideDeleteModal();
                        });
                });
            </script>
        </main>
    </div>
</x-layout-dashboard>
