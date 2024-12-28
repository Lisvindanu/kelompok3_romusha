<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto my-6 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Category Management</h1>

    <!-- Notifications -->
    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form for Create and Edit -->
    <form id="category-form" class="bg-white p-4 shadow-md rounded-lg mb-6">
        <h2 class="text-lg font-semibold mb-4">Add / Update Category</h2>
        <input type="hidden" id="category-id">
        <div class="mb-4">
            <label for="category-name" class="block text-gray-700 font-medium mb-2">Name</label>
            <input type="text" id="category-name" class="border rounded w-full py-2 px-3" placeholder="Enter category name" required>
        </div>
        <button type="button" onclick="saveCategory()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
            Save Category
        </button>
        <button type="button" onclick="resetForm()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md ml-2">
            Reset
        </button>
    </form>

    <!-- Category List -->
    @if(count($categories) > 0)
        <div id="category-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="bg-white p-4 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ $category['name'] }}</h2>
                    <div class="mt-4 flex gap-2">
                        <button onclick="editCategory({{ $category['id'] }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300">
                            Edit
                        </button>
                        <button onclick="deleteCategory({{ $category['id'] }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm transition-colors duration-300">
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">No categories available.</p>
        </div>
    @endif
</div>

<script>
    const apiUrl = '/categories';

    function resetForm() {
        document.getElementById('category-form').reset();
        document.getElementById('category-id').value = '';
    }

    async function saveCategory() {
        const id = document.getElementById('category-id').value;
        const name = document.getElementById('category-name').value.trim();

        if (!name) {
            alert('Please enter a category name.');
            return;
        }

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}/${id}` : apiUrl;

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Category saved successfully!');
                resetForm();
                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to save category');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        }
    }

    async function editCategory(id) {
        try {
            const response = await fetch(`${apiUrl}/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            const category = data.data;

            document.getElementById('category-id').value = category.id;
            document.getElementById('category-name').value = category.name;

            document.getElementById('category-form').scrollIntoView({ behavior: 'smooth' });
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while fetching the category');
        }
    }

    async function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    alert('Category deleted successfully!');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to delete category');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            }
        }
    }
</script>
</body>
</html>
