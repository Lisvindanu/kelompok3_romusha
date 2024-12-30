<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>
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
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Products</h1>
            </div>

            <div class="flex justify-start mb-4">
                <a href="/dashboard/products/create"
                    class="bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 font-semibold px-3 py-1 rounded flex items-center space-x-2 transition-colors duration-200">
                    <span>Create new product</span>
                    <span class="text-sm">&raquo;</span>
                </a>
            </div>

            @foreach ($groupedProducts as $categoryName => $products)
                <div class="my-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $categoryName }}</h2>

                    <!-- Responsive List for Mobile -->
                    <div class="overflow-x-auto bg-white rounded shadow mt-4 md:hidden">
                        <div class="flex flex-col space-y-4">
                            @foreach ($products as $product)
                                <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                                    <div class="flex justify-between">
                                        <h2 class="text-lg font-semibold text-gray-900">{{ $product['name'] }}</h2>
                                        <span class="text-gray-500 text-sm">{{ $product['quantity'] }} Stok</span>
                                        <!-- Menampilkan stok -->
                                    </div>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <!-- View -->
                                        <a href="/dashboard/show-product/{{ $product['id'] }}"
                                            class="text-blue-500 hover:text-blue-700">
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">
                                                View <i class="fa-regular fa-eye"></i>
                                            </span>
                                        </a>
                                        <!-- Edit -->
                                        <a href="dashboard/products/edit/{{ $product['id'] }}"
                                            class="text-yellow-500 hover:text-yellow-700">
                                            <span
                                                class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">
                                                Edit <i class="fa-regular fa-pen-to-square"></i>
                                            </span>
                                        </a>
                                        <!-- Delete -->
                                        <!-- Delete Button -->
                                        <button onclick="confirmDeleteButton({{ $product['id'] }})"
                                            class="text-red-500 hover:text-red-700 flex items-center">
                                            <span
                                                class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                Delete <i class="fa-regular fa-circle-xmark"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
                                        Stok</th> <!-- Menambahkan header Stok -->
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $index => $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product['name'] }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product['quantity'] }}</td> <!-- Menampilkan stok -->
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">
                                            <div class="flex items-center space-x-2">
                                                <a href="/dashboard/products/show-product/{{ $product['id'] }}"
                                                    class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <span
                                                        class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                        View <i class="fa-regular fa-eye"></i>
                                                    </span>
                                                </a>
                                                <a href="/dashboard/products/edit/{{ $product['id'] }}"
                                                    class="text-yellow-500 hover:text-yellow-700 flex items-center">
                                                    <span
                                                        class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                        Edit <i class="fa-regular fa-pen-to-square"></i>
                                                    </span>
                                                </a>
                                                <!-- Delete Button -->
                                                <button onclick="confirmDeleteButton({{ $product['id'] }})"
                                                    class="text-red-500 hover:text-red-700 flex items-center">
                                                    <span
                                                        class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                                                        Delete <i class="fa-regular fa-circle-xmark"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
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
                let deleteFormId = null;

                // Show confirmation modal
                function confirmDeleteButton(productId) {
                    deleteFormId = productId;
                    document.getElementById('deleteModal').classList.remove('hidden');
                }

                // Hide confirmation modal
                function hideDeleteModal() {
                    document.getElementById('deleteModal').classList.add('hidden');
                }

                // Handle delete action
                async function deleteProduct(id) {
                    try {
                        const response = await fetch(`/dashboard/products/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            alert('Product deleted successfully');
                            window.location.href = '/dashboard/products';
                        } else {
                            throw new Error(data.message || 'Failed to delete product');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error deleting product: ' + error.message);
                    } finally {
                        hideDeleteModal();
                    }
                }

                // Add event listener to confirm delete button
                document.addEventListener('DOMContentLoaded', function() {
                    // Add event listener to confirm delete button
                    const confirmButton = document.getElementById('confirmDeleteButton');
                    if (confirmButton) {
                        confirmButton.onclick = function() {
                            if (deleteFormId) {
                                deleteProduct(deleteFormId);
                            }
                        };
                    }
                });
            </script>
        </main>
    </div>
</x-layout-dashboard>
