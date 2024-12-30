<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <!-- Header -->
            <header class="mb-4 lg:mb-6">
                <div class="flex flex-wrap items-center space-x-4 mt-4">
                    <a href="/dashboard/products"
                        class="text-blue-600 hover:text-blue-800 font-semibold flex items-center space-x-1">
                        <span class="text-sm">&laquo;</span>
                        <span>Back</span>
                    </a>

                    <!-- Edit Button -->
                    <a href="/dashboard/products/edit/{{ $product['id'] }}"
                        class="text-yellow-500 hover:text-yellow-700 flex items-center">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Edit <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                    </a>

                    <!-- Delete Button -->
                    <button onclick="confirmDeleteButton({{ $product['id'] }})"
                        class="text-red-500 hover:text-red-700 flex items-center">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Delete <i class="fa-regular fa-circle-xmark"></i>
                        </span>
                    </button>
                </div>
            </header>

            <!-- Product Details -->
            <section class="bg-gray-100 flex items-center justify-center py-8">
                <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative overflow-hidden rounded-lg group">
                            @if (isset($product['imageUrl']) && !empty($product['imageUrl']))
                                <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                                    src="{{ 'https://virtual-realm.my.id' . $product['imageUrl'] }}"
                                    alt="{{ $product['name'] }}"
                                    onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col">
                            <p class="text-sm text-gray-600 italic mb-6">{{ $product['description'] }}</p>
                            <p class="text-xl font-semibold text-blue-500 mb-4">Rp
                                {{ number_format($product['price'], 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600 mb-2"><strong>Stok:</strong> {{ $product['quantity'] }} unit
                            </p>
                            <p class="text-sm text-gray-600 mb-6"><strong>Kategori:</strong>
                                {{ $product['categoryName'] }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Spesifikasi</h2>
                        <ul class="text-sm text-gray-600 list-disc ml-6 space-y-2">
                            {{-- <li>Platform: {{ $product['platform'] }}</li> --}}
                            <li>Genre:
                                @if (!empty($product['genres']))
                                    <ul class="list-disc ml-6">
                                        @foreach ($product['genres'] as $genre)
                                            <li>{{ $genre['name'] }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Tidak ada genre tersedia</span>
                                @endif
                            </li>
                            <li><b>specifications:</b> {!! $product['specifications'] !!}</li>
                        </ul>
                    </div>
                </div>
            </section>
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
        </main>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }

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
</x-layout-dashboard>
