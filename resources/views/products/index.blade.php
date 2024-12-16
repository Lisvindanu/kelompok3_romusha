<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div class="container mx-auto my-6">
    <h1 class="text-2xl font-bold mb-4">Product List</h1>

    <!-- Cek apakah ada produk yang ditemukan -->
    @if(count($products) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white p-4 shadow-md rounded-lg">
                    <img src="{{ 'https://virtual-realm.my.id/' . $product['imageUrl'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover mb-4">
                    <h2 class="text-xl font-semibold">{{ $product['name'] }}</h2>
                    <p class="text-gray-600">Category: {{ $product['categoryName'] }}</p>
                    <p class="text-gray-600">Price: Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                    <p class="text-gray-600">Quantity: {{ $product['quantity'] }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>No products available.</p>
    @endif
</div>

</body>
</html>
