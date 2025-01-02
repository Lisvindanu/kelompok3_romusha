<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <main class="flex-1 p-6">
            <div class="flex justify-between items-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-semibold">Product Console</h1>
            </div>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form for Create and Update -->
            <form id="product-form" class="bg-white p-4 shadow-md rounded-lg mb-6">
                <h2 class="text-lg font-semibold mb-4">Add / Update Product</h2>
                <input type="hidden" id="product-id">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" id="product-name" class="border rounded w-full py-2 px-3"
                        placeholder="Enter product name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="product-description" class="border rounded w-full py-2 px-3" placeholder="Enter product description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Specifications</label>
                    <textarea id="product-specifications" class="border rounded w-full py-2 px-3" placeholder="Enter specifications"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" id="product-price" class="border rounded w-full py-2 px-3"
                        placeholder="Enter product price" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <input type="number" id="product-quantity" class="border rounded w-full py-2 px-3"
                        placeholder="Enter product quantity" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <select id="product-category" class="border rounded w-full py-2 px-3" required>
                        <option value="">Select a category</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Genres</label>
                    <div id="genre-list" class="space-y-2">
                        <!-- Genres will be populated dynamically -->
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Image</label>
                    <input type="file" id="product-image" class="border rounded w-full py-2 px-3" accept="image/*"
                        onchange="previewImage(event)">
                    <img id="image-preview" class="mt-4 w-full h-auto rounded shadow-md" style="display: none;"
                        alt="Image Preview">
                </div>

                <button type="button" onclick="saveProduct()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Save Product
                </button>
            </form>

            <!-- Product List -->
            @if (count($products) > 0)
                <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white p-4 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300">
                            @if ($product['imageUrl'])
                                <img src="{{ 'https://virtual-realm.my.id' . $product['imageUrl'] }}"
                                    alt="{{ $product['name'] }}" class="w-full h-48 object-cover rounded-lg mb-4"
                                    onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif

                            <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ $product['name'] }}</h2>

                            <div class="space-y-2">
                                <p class="text-gray-600">
                                    <span class="font-medium">Category:</span>
                                    {{ $product['categoryName'] }}
                                </p>

                                @if (!empty($product['genres']))
                                    <div class="text-gray-600">
                                        <span class="font-medium">Genres:</span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach ($product['genres'] as $genre)
                                                <span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs">
                                                    {{ $genre['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <p class="text-gray-600">
                                    <span class="font-medium">Price:</span>
                                    <span class="text-green-600 font-semibold">
                                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                                    </span>
                                </p>

                                <p class="text-gray-600">
                                    <span class="font-medium">Stock:</span>
                                    @if ($product['quantity'] > 0)
                                        <span class="text-green-600">{{ $product['quantity'] }} available</span>
                                    @else
                                        <span class="text-red-600">Out of stock</span>
                                    @endif
                                </p>

                                @if ($product['description'])
                                    <p class="text-gray-600 mt-2">
                                        <span class="font-medium">Description:</span><br>
                                        <span class="text-sm">{{ Str::limit($product['description'], 100) }}</span>
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4 flex gap-2">
                                <button onclick="editProduct({{ $product['id'] }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300">
                                    Edit
                                </button>
                                <button onclick="deleteProduct({{ $product['id'] }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-600">No products available.</p>
                </div>
            @endif
        </main>

        <script>
            const apiUrl = '/products';
            const springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api';

            // Fetch categories and populate select
            async function fetchCategories() {
                try {
                    const response = await fetch(`${springBootApiUrl}/categories`, {
                        headers: {
                            'X-Api-Key': 'secret',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();

                    const categorySelect = document.getElementById('product-category');

                    // Clear existing options
                    while (categorySelect.options.length > 1) {
                        categorySelect.remove(1);
                    }

                    const categories = Array.isArray(data) ? data : data.data;

                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching categories:', error);
                }
            }

            // Fetch genres based on selected category
            async function fetchGenresByCategory(categoryId) {
                if (!categoryId) return;

                try {
                    const response = await fetch(`${springBootApiUrl}/genres`, {
                        headers: {
                            'X-Api-Key': 'secret',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();
                    const genreList = document.getElementById('genre-list');
                    genreList.innerHTML = '';

                    const categoryGenres = data.filter(
                        genre => genre.category && genre.category.id === parseInt(categoryId)
                    );

                    if (categoryGenres.length === 0) {
                        genreList.innerHTML = '<p class="text-gray-500">No genres available for this category</p>';
                        return;
                    }

                    categoryGenres.forEach(genre => {
                        const div = document.createElement('div');
                        div.className = 'flex items-center';
                        div.innerHTML = `
                    <input type="checkbox" id="genre-${genre.id}" name="genres" value="${genre.id}"
                           class="mr-2 rounded border-gray-300">
                    <label for="genre-${genre.id}" class="text-sm text-gray-700">${genre.name}</label>
                `;
                        genreList.appendChild(div);
                    });
                } catch (error) {
                    console.error('Error fetching genres:', error);
                }
            }

            // Handle category change
            document.getElementById('product-category').addEventListener('change', function(e) {
                const categoryId = e.target.value;
                if (categoryId) {
                    fetchGenresByCategory(categoryId);
                } else {
                    document.getElementById('genre-list').innerHTML = '';
                }
            });


            function resetForm() {
                // Reset the form fields
                document.getElementById('product-form').reset();
                document.getElementById('product-id').value = '';

                // Clear genre list
                document.getElementById('genre-list').innerHTML = '';

                // Reset category select to default option
                const categorySelect = document.getElementById('product-category');
                categorySelect.selectedIndex = 0;

                // Reset file input
                const fileInput = document.getElementById('product-image');
                fileInput.value = '';
            }

            // Save product function - Updated version
            async function saveProduct() {
                const id = document.getElementById('product-id').value;
                const imageFile = document.getElementById('product-image').files[0];

                const productData = {
                    name: document.getElementById('product-name').value.trim(),
                    description: document.getElementById('product-description').value.trim(),
                    specifications: document.getElementById('product-specifications').value.trim(),
                    price: parseInt(document.getElementById('product-price').value),
                    quantity: parseInt(document.getElementById('product-quantity').value),
                    categoryId: parseInt(document.getElementById('product-category').value),
                    genreIds: Array.from(document.querySelectorAll('input[name="genres"]:checked')).map(input =>
                        parseInt(input.value)),
                };

                if (!productData.name || !productData.price || !productData.quantity || !productData.categoryId) {
                    alert('Please fill in all required fields (Name, Price, Quantity, and Category)');
                    return;
                }

                const formData = new FormData();
                formData.append('body', JSON.stringify(productData));
                if (imageFile) {
                    formData.append('file', imageFile);
                }

                const method = id ? 'PUT' : 'POST';
                const url = id ? `${springBootApiUrl}/products/${id}` : `${springBootApiUrl}/products`;

                try {
                    const response = await fetch(url, {
                        method,
                        headers: {
                            'X-Api-Key': 'secret',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.status === 'success') {
                        alert('Product saved successfully!');
                        resetForm();
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to save product');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                }
            }


            // Add this event listener to prevent form submission on enter key
            document.getElementById('product-form').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    return false;
                }
            });

            // Fungsi terpisah untuk upload gambar
            async function handleImageUpload(productId) {
                const imageFile = document.getElementById('product-image').files[0];
                if (!imageFile) return;

                const formData = new FormData();
                formData.append('file', imageFile);

                try {
                    await fetch(`${apiUrl}/${productId}/image`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Api-Key': 'secret'
                        },
                        body: formData
                    });
                } catch (error) {
                    console.error('Error uploading image:', error);
                }
            }

            // Edit product
            async function editProduct(id) {
                try {
                    const response = await fetch(`${apiUrl}/${id}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Api-Key': 'secret'
                        }
                    });

                    const data = await response.json();
                    const product = data.data;

                    // Isi form dengan data produk
                    document.getElementById('product-id').value = product.id;
                    document.getElementById('product-name').value = product.name;
                    document.getElementById('product-description').value = product.description || '';
                    document.getElementById('product-specifications').value = product.specifications || '';
                    document.getElementById('product-price').value = product.price;
                    document.getElementById('product-quantity').value = product.quantity;
                    document.getElementById('product-category').value = product.categoryId;

                    // Tampilkan genres yang dipilih
                    await fetchGenresByCategory(product.categoryId);
                    setTimeout(() => {
                        product.genres.forEach(genre => {
                            const checkbox = document.querySelector(`input[value="${genre.id}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                            }
                        });
                    }, 100);

                    // Tampilkan gambar jika ada
                    const preview = document.getElementById('image-preview');
                    if (product.imageUrl) {
                        preview.src = `https://virtual-realm.my.id${product.imageUrl}`;
                        preview.style.display = 'block';
                    } else {
                        preview.src = '';
                        preview.style.display = 'none';
                    }

                    // Scroll ke form
                    document.getElementById('product-form').scrollIntoView({
                        behavior: 'smooth'
                    });
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the product');
                }
            }


            // Delete product
            async function deleteProduct(id) {
                if (confirm('Are you sure you want to delete this product?')) {
                    try {
                        const response = await fetch(`${apiUrl}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.status === 'success') {
                            location.reload();
                        } else {
                            alert(`Error: ${data.message}`);
                        }
                    } catch (error) {
                        console.error('Error deleting product:', error);
                        alert('An error occurred while deleting the product');
                    }
                }
            }

            // On page load, fetch categories
            document.addEventListener('DOMContentLoaded', function() {
                fetchCategories();
            });

            function previewImage(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('image-preview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            }
        </script>

    </div>
</x-layout-dashboard>
