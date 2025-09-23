@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Shop All Products</h1>
            <p class="text-gray-700">Browse all products offered by <span class="text-orange-600 font-semibold">Gemarc Enterprises Inc.</span></p>
        </div>
        <form class="mt-4 md:mt-0 flex gap-2">
            <input type="text" class="border border-green-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Search products...">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Search</button>
        </form>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @for ($i = 1; $i <= 8; $i++)
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                <img src="https://via.placeholder.com/180x120?text=Product+{{ $i }}" alt="Product {{ $i }}" class="mb-3 rounded">
                <div class="font-bold text-green-900 text-lg mb-1">Product {{ $i }}</div>
                <div class="text-gray-600 mb-2">Short description of product {{ $i }} goes here.</div>
                <div class="text-orange-600 font-bold text-xl mb-2">₱{{ number_format(1000 * $i, 2) }}</div>
                <button class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">View Details</button>
            </div>
        @endfor
    </div>
    <div class="mt-8 text-sm text-gray-500 text-center">
        <span class="text-green-800 font-semibold">Gemarc Enterprises Inc.</span> is an authorized distributor of select partner brands. All products are curated for quality and reliability.
    </div>
</div>
@endsection
