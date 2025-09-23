@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Employee Dashboard</h1>
            <p class="text-gray-700">Welcome, {{ auth()->user()->name }}! Manage products, inventory, and orders here.</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="#" class="bg-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-green-50 transition">
            <img src="/images/gemarclogo.png" alt="Products" class="w-12 h-12 mb-2">
            <div class="font-bold text-green-800">Product Management</div>
            <div class="text-xs text-gray-500">Add, edit, or remove products</div>
        </a>
        <a href="#" class="bg-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-green-50 transition">
            <img src="/images/gemarclogo.png" alt="Inventory" class="w-12 h-12 mb-2">
            <div class="font-bold text-orange-600">Inventory</div>
            <div class="text-xs text-gray-500">View and update stock levels</div>
        </a>
        <a href="#" class="bg-white rounded-xl shadow p-6 flex flex-col items-center hover:bg-green-50 transition">
            <img src="/images/gemarclogo.png" alt="Orders" class="w-12 h-12 mb-2">
            <div class="font-bold text-green-800">Order Management</div>
            <div class="text-xs text-gray-500">Process and track orders</div>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-lg font-bold text-green-800 mb-2">Recent Orders</div>
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
@endsection
