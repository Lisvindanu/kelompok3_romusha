<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
                <h1 class="text-xl md:text-2xl font-semibold">Tambah Product Game</h1>
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
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 px-3 py-2 rounded relative mb-4 text-sm" role="alert">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form class="space-y-4" method="POST" action="/dashboard/products" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Produk -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Produk -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <input id="description" type="hidden" name="description" value="{{ old('description') }}">
                        <div
                            class="mt-1 block w-full rounded-md shadow-md text-sm focus:ring-blue-500 focus:border-blue-500 overflow-auto max-h-60">
                            <trix-editor input="description" class="trix-content"></trix-editor>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" id="price" name="price" required value="{{ old('price') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" id="quantity" name="quantity" required value="{{ old('quantity') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('quantity') border-red-500 @enderror">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Platform -->
                    <div>
                        <label for="platform" class="block text-sm font-medium text-gray-700">Platform</label>
                        <input type="text" id="platform" name="platform" required value="{{ old('platform') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('platform') border-red-500 @enderror">
                        @error('platform')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Release Date -->
                    <div>
                        <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
                        <input type="date" id="release_date" name="release_date" required
                            value="{{ old('release_date') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('release_date') border-red-500 @enderror">
                        @error('release_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Developer -->
                    <div>
                        <label for="developer" class="block text-sm font-medium text-gray-700">Developer</label>
                        <input type="text" id="developer" name="developer" required value="{{ old('developer') }}"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('developer') border-red-500 @enderror">
                        @error('developer')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category_id" name="category_id" required
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="1">Console</option>
                            <option value="2">Accessories</option>
                            <option value="3">Games</option>
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                        <select id="genre_id" name="genre_id" required
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('genre_id') border-red-500 @enderror">
                            <option value="">Pilih Genre</option>
                            <option value="1">Action</option>
                            <option value="2">Adventure</option>
                            <option value="3">RPG</option>
                        </select>
                        @error('genre_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="mt-1 block w-full rounded-md shadow-md text-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror"
                            onchange="previewImage()">
                        <img class="img-preview w-36 h-36 object-contain mt-3 mb-3 rounded-lg" style="display: none;">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md text-sm">Tambahkan
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
