@extends('layouts.app')
@section('title', 'Saved Items | Gemarc Enterprises Inc.')
@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-green-800">Saved Items</h1>
            <a href="{{ route('shop.index') }}" class="bg-orange-500 text-white px-4 py-2 rounded font-semibold hover:bg-orange-600 transition">Go to All Products</a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if($savedItems->isEmpty())
            <div class="text-gray-500 text-center py-12">No saved items yet.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($savedItems as $item)
                    @php $product = $item->product; @endphp
                    <div class="bg-white rounded-xl shadow flex flex-col md:flex-row items-center p-4 gap-4">
                        <img src="{{ $product && $product->firstImagePath() ? asset('storage/'.$product->firstImagePath()) : '/images/gemarclogo.png' }}" alt="{{ $product->name ?? 'Product' }}" class="w-24 h-24 object-contain rounded">
                        <div class="flex-1">
                            <div class="font-bold text-green-800 text-lg">{{ $product->name ?? 'Product not found' }}</div>
                            <div class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $product->description ?? '' }}</div>
                            <div class="text-orange-600 font-bold text-lg mb-2">₱{{ number_format($product->price ?? 0,2) }}</div>
                            <form method="POST" action="{{ route('saved.destroy', $item->id) }}" onsubmit="return confirm('Remove this item from saved?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm font-semibold hover:bg-red-600">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
