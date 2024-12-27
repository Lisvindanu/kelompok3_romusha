<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto my-6 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Product List</h1>

    @if(count($products) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white p-4 shadow-md rounded-lg">
                    @if($product['imageUrl'])
                        <img
                            src="{{ 'https://virtual-realm.my.id' . $product['imageUrl'] }}"
                            alt="{{ $product['name'] }}"
                            class="w-full h-48 object-cover rounded-lg mb-4"
                            onerror="this.src='https://virtual-realm.my.id/uploads/images/default-image.jpg'"
                        >
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

                        @if(!empty($product['genres']))
                            <div class="text-gray-600">
                                <span class="font-medium">Genres:</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($product['genres'] as $genre)
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
                            @if($product['quantity'] > 0)
                                <span class="text-green-600">{{ $product['quantity'] }} available</span>
                            @else
                                <span class="text-red-600">Out of stock</span>
                            @endif
                        </p>

                        @if($product['description'])
                            <p class="text-gray-600 mt-2">
                                <span class="font-medium">Description:</span><br>
                                <span class="text-sm">{{ Str::limit($product['description'], 100) }}</span>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">No products available.</p>
        </div>
    @endif
</div>

</body>
</html>
