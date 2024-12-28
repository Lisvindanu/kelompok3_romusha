@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Delete Product</h1>
    
    <div id="productDetails" class="max-w-2xl bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Product Information</h2>
            <div id="productInfo">
                Loading product information...
            </div>
        </div>

        <div class="mt-6">
            <div class="bg-red-50 border border-red-200 rounded p-4 mb-4">
                <p class="text-red-700">
                    Warning: This action cannot be undone. Deleting this product will permanently remove it from the system.
                </p>
            </div>
            
            <button id="deleteButton" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Delete Product
            </button>
            
            <a href="/products" class="ml-4 text-gray-600 hover:text-gray-800">
                Cancel
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function loadProduct(id) {
    try {
        const response = await fetch(`/api/products/${id}`);
        const result = await response.json();
        
        if (response.ok) {
            const product = result.data;
            document.getElementById('productInfo').innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-medium">Name</p>
                        <p>${product.name}</p>
                    </div>
                    <div>
                        <p class="font-medium">Price</p>
                        <p>$${product.price.toFixed(2)}</p>
                    </div>
                    <div>
                        <p class="font-medium">Quantity</p>
                        <p>${product.quantity}</p>
                    </div>
                    <div>
                        <p class="font-medium">Category</p>
                        <p>${product.categoryName || 'N/A'}</p>
                    </div>
                </div>
                ${product.imageUrl ? `
                    <div class="mt-4">
                        <p class="font-medium">Product Image</p>
                        <img src="${product.imageUrl}" alt="${product.name}" class="w-32 h-32 object-cover mt-2">
                    </div>
                ` : ''}
            `;
        } else {
            document.getElementById('productInfo').innerHTML = 'Error loading product information.';
        }
    } catch (error) {
        document.getElementById('productInfo').innerHTML = 'Error loading product information: ' + error.message;
    }
}

document.getElementById('deleteButton').addEventListener('click', async () => {
    if (!confirm('Are you sure you want to delete this product?')) {
        return;
    }
    
    const productId = new URLSearchParams(window.location.search).get('id');
    
    try {
        const response = await fetch(`/api/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();
        
        if (response.ok) {
            alert('Product deleted successfully');
            window.location.href = '/products';
        } else {
            alert(result.message || 'Failed to delete product');
        }
    } catch (error) {
        alert('Error deleting product: ' + error.message);
    }
});

// Load product data when page loads
const productId = new URLSearchParams(window.location.search).get('id');
if (productId) {
    loadProduct(productId);
}
</script>
@endpush