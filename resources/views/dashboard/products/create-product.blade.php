<x-layout-dashboard>
    <div class="flex flex-col min-h-screen md:flex-row">
        <x-sidebar></x-sidebar>

        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Create New Product</h1>

            <div class="flex justify-start mb-4">
                <a href="/dashboard/products"
                    class="bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 font-semibold px-3 py-1 rounded flex items-center space-x-2 transition-colors duration-200">
                    <span class="text-sm">&laquo;</span>
                    <span>Kembali</span>
                </a>
            </div>
            <!-- Form for Create -->
            <form id="product-form" class="bg-white p-4 shadow-md rounded-lg">
                <h2 class="text-lg font-semibold mb-4">Add New Product</h2>
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
                        <!-- Genres dynamically populated -->
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
        </main>

        <script>
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

                    const data = await response.json();
                    const genreList = document.getElementById('genre-list');
                    genreList.innerHTML = ''; // Clear previous genres

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

            // Save product function
            async function saveProduct() {
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

                try {
                    const response = await fetch(`${springBootApiUrl}/products`, {
                        method: 'POST',
                        headers: {
                            'X-Api-Key': 'secret',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok && data.status === 'success') {
                        alert('Product saved successfully!');
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Failed to save product');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
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
