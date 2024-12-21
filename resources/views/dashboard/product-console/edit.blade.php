<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
                <h1 class="text-xl md:text-2xl font-semibold">Edit Product Console</h1>
            </div>

            <div class="mb-4">
                <a href="/dashboard/product-console"
                    class="inline-flex items-center space-x-2 text-sm text-blue-600 bg-blue-100 hover:bg-blue-200 hover:text-blue-800 font-medium px-3 py-1.5 rounded transition-colors duration-200">
                    <span>&laquo;</span>
                    <span>Back</span>
                </a>
            </div>

            <!-- Form Wrapper -->
            <div class="bg-white w-full md:w-5/6 rounded-lg shadow-md p-4 md:p-6">
                <form class="space-y-4" method="POST" action="/dashboard/products/update" enctype="multipart/form-data">
                    <!-- Nama Produk -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" id="name" name="name" required value="PlayStation 5"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input id="description" type="hidden" name="description"
                            value="PlayStation 5 adalah konsol terbaru dari Sony dengan performa luar biasa.">
                        <div
                            class="mt-1 block w-full rounded-md shadow-md text-sm focus:ring-blue-500 focus:border-blue-500 overflow-auto max-h-60">
                            <trix-editor input="description" class="trix-content"></trix-editor>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" id="price" name="price" required value="7500000"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="quantity" name="quantity" required value="20"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category_id" name="category_id" required
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1" selected>Console</option>
                            <option value="2">Accessories</option>
                            <option value="3">Games</option>
                        </select>
                    </div>

                    <!-- Prosesor -->
                    <div>
                        <label for="processor" class="block text-sm font-medium text-gray-700">Prosesor</label>
                        <input type="text" id="processor" name="processor" required value="AMD Ryzen Zen 2"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- GPU -->
                    <div>
                        <label for="gpu" class="block text-sm font-medium text-gray-700">GPU</label>
                        <input type="text" id="gpu" name="gpu" required value="AMD RDNA 2"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- RAM -->
                    <div>
                        <label for="ram" class="block text-sm font-medium text-gray-700">RAM</label>
                        <input type="text" id="ram" name="ram" required value="16GB GDDR6"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Storage -->
                    <div>
                        <label for="storage" class="block text-sm font-medium text-gray-700">Storage</label>
                        <input type="text" id="storage" name="storage" required value="825GB SSD"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Resolusi -->
                    <div>
                        <label for="resolution" class="block text-sm font-medium text-gray-700">Resolusi</label>
                        <input type="text" id="resolution" name="resolution" required value="4K"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                            onchange="previewImage()">
                        <img src="{{ asset('storage/img/Supermario.jpg') }}"
                            class="img-preview w-36 h-36 object-contain mt-3 mb-3 rounded-lg">
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-sm">
                            Update Produk
                        </button>
                    </div>
                </form>
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
    </script>
</x-layout-dashboard>
