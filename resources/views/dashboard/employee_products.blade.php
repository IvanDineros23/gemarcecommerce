@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Product Management</h1>
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-green-700 mb-4">Add New Product</h2>
        <form method="POST" action="{{ route('employee.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Description</label>
                <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Price</label>
                <input type="number" name="price" class="w-full border border-gray-300 rounded px-3 py-2" min="0" step="0.01" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Image</label>
                <input type="file" name="image" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Add Product</button>
        </form>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-green-700 mb-4">All Products</h2>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Name</th>
                    <th class="py-2">Description</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Image</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="py-2">{{ $product->name }}</td>
                    <td class="py-2">{{ $product->description }}</td>
                    <td class="py-2">₱{{ number_format($product->price, 2) }}</td>
                    <td class="py-2">
                        @php $img = $product->firstImagePath(); @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </td>
                    <td class="py-2">
                        <a href="{{ route('employee.products.edit', $product) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('employee.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
