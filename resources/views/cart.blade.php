<x-layout>
    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-bold mb-6 mt-10 text-center text-white font-pixelify">
            Keranjang Belanja
        </h1>

        <!-- Cart Wrapper -->
        <div class="w-full max-w-5xl bg-neutral-800 shadow-md rounded-lg p-4 sm:p-6">
            @if(!$cartItems->isEmpty())
                <!-- Product Table -->
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                    <tr class="bg-neutral-700 text-gray-300 uppercase text-[10px] sm:text-xs">
                        <th class="px-2 sm:px-4 py-2 sm:py-3">
                            <input type="checkbox" id="select-all"
                                   class="w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 bg-gray-300 rounded-md border-gray-500" />
                        </th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Produk</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Harga</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Jumlah</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Subtotal</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr class="border-b border-neutral-700" data-item-id="{{ $item['id'] }}">
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                                <input type="checkbox"
                                       class="product-check w-4 sm:w-5 h-4 sm:h-5 text-yellow-400 bg-gray-300 rounded-md border-gray-500" />
                            </td>
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800 flex items-center space-x-2 sm:space-x-4">
                                <img src="{{ 'https://virtual-realm.my.id' . $item['image_url'] }}"
                                     alt="{{ $item['product_name'] }}"
                                     class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-lg border border-gray-600"
                                     onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                                <span class="font-medium text-white text-xs sm:text-sm">{{ $item['product_name'] }}</span>
                            </td>
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                                <button class="quantity-btn w-full sm:w-auto rounded bg-gray-700 py-1 px-2 text-white text-xs"
                                        data-item-id="{{ $item['id'] }}" data-current-quantity="{{ $item['quantity'] }}">
                                    {{ $item['quantity'] }}
                                </button>
                            </td>
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800 text-gray-300 text-xs sm:text-sm">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-4 py-2 bg-neutral-800">
                                <button onclick="removeFromCart({{ $item['id'] }})"
                                        class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Total Price Display -->
                <div class="mt-4 text-right">
                    <p class="text-lg font-semibold text-white">
                        Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex flex-col sm:flex-row sm:justify-between items-center gap-4">
                    <button onclick="removeSelectedItems()"
                            class="w-full sm:w-auto rounded-full border-2 border-yellow-400 py-2 px-6 text-[10px] sm:text-sm font-bold text-yellow-400 hover:bg-yellow-400 hover:text-red-700 transition-all font-pixelify">
                        Hapus Produk Terpilih
                    </button>
                    <button onclick="checkoutSelectedItems()"
                            class="w-full sm:w-auto rounded-full bg-yellow-400 py-2 px-6 text-[10px] sm:text-sm font-bold text-red-700 hover:bg-yellow-500 hover:scale-105 transition-all font-pixelify">
                        Checkout Produk Terpilih
                    </button>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-400">Keranjang belanja Anda kosong</p>
                    <a href="/cart-back" class="mt-4 inline-block text-yellow-400 hover:text-yellow-500">
                        Mulai Berbelanja
                    </a>
                </div>
            @endif
        </div>
    </div>
    <x-footer></x-footer>

    <!-- Modal -->
    <div id="updateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-neutral-900 p-6 rounded shadow-lg">
            <h2 class="text-lg text-white mb-4">Update Jumlah</h2>
            <input type="text" id="newQuantity" class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Masukkan jumlah baru">
            <div class="flex justify-end mt-4 space-x-2">
                <button id="cancelBtn" class="px-4 py-2 bg-gray-600 text-white rounded">Batal</button>
                <button id="saveBtn" class="px-4 py-2 bg-yellow-500 text-red-700 rounded">Simpan</button>
            </div>
        </div>
    </div>

    <script>
        let currentItemId = null;

        // Open modal for quantity update
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', () => {
                const currentQuantity = button.dataset.currentQuantity;
                currentItemId = button.dataset.itemId;
                document.getElementById('newQuantity').value = currentQuantity;
                document.getElementById('updateModal').classList.remove('hidden');
            });
        });

        // Close modal
        document.getElementById('cancelBtn').addEventListener('click', () => {
            document.getElementById('updateModal').classList.add('hidden');
        });

        // Save new quantity
        document.getElementById('saveBtn').addEventListener('click', async () => {
            const newQuantity = document.getElementById('newQuantity').value;

            if (!newQuantity || parseInt(newQuantity) < 1) {
                alert('Masukkan jumlah yang valid!');
                return;
            }

            try {
                const response = await fetch(`/cart/update/${currentItemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quantity: parseInt(newQuantity) })
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Gagal memperbarui jumlah!');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memperbarui jumlah!');
            } finally {
                document.getElementById('updateModal').classList.add('hidden');
            }
        });

        // Remove item
        async function removeFromCart(itemId) {
            if (confirm('Are you sure you want to remove this item?')) {
                try {
                    const response = await fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Failed to remove item');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to remove item');
                }
            }
        }

        // Select all
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.product-check').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Remove selected items
        async function removeSelectedItems() {
            const selectedItems = Array.from(document.querySelectorAll('.product-check:checked'))
                .map(checkbox => checkbox.closest('tr').dataset.itemId);

            if (!selectedItems.length) {
                alert('Please select items to remove');
                return;
            }

            if (confirm('Are you sure you want to remove selected items?')) {
                try {
                    await Promise.all(selectedItems.map(itemId =>
                        fetch(`/cart/remove/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                    ));
                    window.location.reload();
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to remove selected items');
                }
            }
        }

        // Checkout selected items
        function checkoutSelectedItems() {
            const selectedItems = Array.from(document.querySelectorAll('.product-check:checked'))
                .map(checkbox => checkbox.closest('tr').dataset.itemId);

            if (!selectedItems.length) {
                alert('Please select items to checkout');
                return;
            }

            window.location.href = `/paymentCarts?items=${selectedItems.join(',')}`;
        }
    </script>
</x-layout>
