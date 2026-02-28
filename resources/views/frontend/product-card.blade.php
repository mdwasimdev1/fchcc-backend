<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8 text-center">Our Products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($products as $product)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden">

            <!-- Product Image -->
            <div class="relative">
                <img src="{{ $product->image }}" 
                     class="w-full h-56 object-cover">

                @if($product->discount_price)
                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded">
                    SALE
                </span>
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-2">
                    {{ $product->name }}
                </h2>

                <!-- Rating -->
                <div class="flex items-center mb-2 text-yellow-400">
                    ★★★★☆
                </div>

                <!-- Price -->
                <div class="mb-4">
                    @if($product->discount_price)
                        <span class="text-gray-400 line-through">
                            ${{ $product->price }}
                        </span>
                        <span class="text-red-600 font-bold ml-2">
                            ${{ $product->discount_price }}
                        </span>
                    @else
                        <span class="text-gray-800 font-bold">
                            ${{ $product->price }}
                        </span>
                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">
                    <a href="#" 
                       class="text-sm text-blue-600 hover:underline">
                        View Details
                    </a>

                    <form action="{{ route('product.add-to-cart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                            class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endforeach

    </div>
</div>

</body>
</html>