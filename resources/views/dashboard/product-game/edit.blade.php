<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
                <h1 class="text-xl md:text-2xl font-semibold">Edit Product Game</h1>
            </div>

            <div class="mb-4">
                <a href="/dashboard/product-game"
                    class="inline-flex items-center space-x-2 text-sm text-blue-600 bg-blue-100 hover:bg-blue-200 hover:text-blue-800 font-medium px-3 py-1.5 rounded transition-colors duration-200">
                    <span>&laquo;</span>
                    <span>Back</span>
                </a>
            </div>

            <!-- Form Wrapper -->
            <div class="bg-white w-full md:w-5/6 rounded-lg shadow-md p-4 md:p-6">
                <form class="space-y-4">
                    <!-- Nama Produk -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" id="name" name="name" value="" placeholder="Nama Produk"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input id="description" type="hidden" name="description" value="">
                        <div
                            class="mt-1 block w-full rounded-md shadow-md text-sm focus:ring-blue-500 focus:border-blue-500 overflow-auto max-h-60">
                            <trix-editor input="description" class="trix-content"></trix-editor>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" id="price" name="price" value="" placeholder="Harga"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="quantity" name="quantity" value="" placeholder="Jumlah"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Platform -->
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700">Platform</label>
                        <input type="text" id="platform" name="platform" value="" placeholder="Platform"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Release Date -->
                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
                        <input type="date" id="release_date" name="release_date" value=""
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Developer -->
                    <div>
                        <label for="developer" class="block text-sm font-medium text-gray-700">Developer</label>
                        <input type="text" id="developer" name="developer" value="" placeholder="Developer"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category_id" name="category_id"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="1">Console</option>
                            <option value="2">Accessories</option>
                            <option value="3">Games</option>
                        </select>
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                        <select id="genre_id" name="genre_id"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Genre</option>
                            <option value="1">Action</option>
                            <option value="2">Adventure</option>
                            <option value="3">RPG</option>
                        </select>
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500"
                            onchange="previewImage()">
                        <img class="img-preview w-36 h-36 object-contain mt-3 mb-3 rounded-lg" style="display: none;">
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <button type="button"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-sm">Update
                            Produk</button>
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
