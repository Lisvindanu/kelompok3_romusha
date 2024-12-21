<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 overflow-auto">
            <!-- Header -->
            <header class="mb-4 lg:mb-6">
                <div class="flex flex-wrap items-center space-x-4 mt-4">
                    <a href="/dashboard/product-console"
                        class="text-blue-600 hover:text-blue-800 font-semibold flex items-center space-x-1">
                        <span class="text-sm">&laquo;</span>
                        <span>Back</span>
                    </a>

                    <!-- Edit Button -->
                    <a href="/dashboard/edit-product-console"
                        class="text-yellow-500 hover:text-yellow-700 flex items-center">
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Edit <i class="fa-regular fa-pen-to-square"></i>
                        </span>
                    </a>

                    <!-- Delete Button -->
                    <form action="#" method="post" class="inline" {{-- id="deleteForm{{ $post->id }}">--}
                        @method('delete')
                        @csrf
                        <button type="button" {{-- onclick="showDeleteModal({{ $post->id }})" --}}
                        class="text-red-500 hover:text-red-700 flex items-center">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold mr-1">
                            Delete <i class="fa-regular fa-circle-xmark"></i>
                        </span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Product Details -->
            <section class="bg-gray-100 flex items-center justify-center py-8">
                <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden rounded-lg group">
                            <img class="h-full w-full object-cover rounded-lg group-hover:scale-105 transition-transform duration-500"
                                src="{{ asset('storage/img/Supermario.jpg') }}" alt="PlayStation 5">
                        </div>

                        <!-- Product Information -->
                        <div class="flex flex-col">
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">PlayStation 5</h1>
                            <p class="text-sm text-gray-600 italic mb-6">
                                PlayStation 5 adalah konsol generasi terbaru dari Sony yang menawarkan performa luar
                                biasa
                                dengan prosesor ultra cepat, grafis memukau, dan fitur SSD yang revolusioner.
                            </p>
                            <p class="text-xl font-semibold text-blue-500 mb-4">Rp 7.500.000</p>
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Stok:</strong> 10 unit
                            </p>
                            <p class="text-sm text-gray-600 mb-6">
                                <strong>Kategori:</strong> Console, Gaming
                            </p>
                        </div>
                    </div>

                    <!-- Product Specifications -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Spesifikasi</h2>
                        <ul class="text-sm text-gray-600 list-disc ml-6 space-y-2">
                            <li>Prosesor: AMD Ryzen Zen 2</li>
                            <li>GPU: AMD RDNA 2</li>
                            <li>RAM: 16GB GDDR6</li>
                            <li>Storage: 825GB SSD</li>
                            <li>Resolusi: Hingga 4K</li>
                        </ul>
                    </div>
                </div>
            </section>
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
