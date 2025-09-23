@extends('layouts.app')

@section('content')
<div class="py-8">
    <!-- Search Bar -->
    <form action="{{ route('dashboard.search') }}" method="GET" class="mb-6 flex gap-2 max-w-xl">
        <input type="text" name="q" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Search products, orders, etc...">
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Search</button>
    </form>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-700">Browse and request products from <span class="text-orange-600 font-semibold">Gemarc Enterprises Inc.</span></p>
        </div>
        <a href="{{ route('shop.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded shadow transition">Shop All Products</a>
    </div>
    <!-- ...existing code... -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Create/Request Quote -->
        <div class="bg-white rounded-xl shadow p-6 flex flex-col">
            <div class="text-lg font-bold text-green-800 mb-2 flex items-center gap-2">📝 Request a Quote</div>
            <a href="{{ route('quotes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold w-max">Create Quote</a>
        </div>
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow p-6 flex flex-col">
            <div class="text-lg font-bold text-green-800 mb-2">Your Recent Orders</div>
            <ul class="divide-y">
                @forelse ($recentOrders as $o)
                    <li class="flex items-center justify-between py-4">
                        <div>
                            <div class="font-semibold">#{{ $o->id }} · {{ $o->created_at->format('Y-m-d') }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($o->status) }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-800">₱{{ number_format($o->total_amount,2) }}</div>
                            <a href="{{ route('orders.show',$o) }}" class="text-green-700 hover:underline text-xs ml-2">View</a>
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-gray-400">No orders yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-lg font-bold text-orange-600 mb-2">Recommended for You</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @for ($i = 1; $i <= 4; $i++)
                <div class="bg-gray-50 rounded-xl shadow flex flex-col items-center p-4">
                    <img src="https://via.placeholder.com/120x80?text=Product+{{ $i }}" alt="Product {{ $i }}" class="mb-2 rounded">
                    <div class="font-semibold text-green-900">Product {{ $i }}</div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
