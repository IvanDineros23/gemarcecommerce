@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Employee Dashboard</h1>
            <p class="text-gray-700">Welcome, {{ auth()->user()->name }}! Manage products, inventory, and orders here.</p>
        </div>
    </div>
    <div class="w-full flex flex-col md:flex-row gap-4 mb-8">
        <a href="{{ route('employee.products.index') }}" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <img src="/images/gemarclogo.png" alt="Products" class="w-16 h-16 mb-2">
            <div class="font-bold text-green-800 text-center">Product Management</div>
            <div class="text-xs text-gray-500 text-center">Add, edit, or remove products</div>
        </a>
    <a href="{{ route('employee.inventory.index') }}" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <img src="/images/gemarclogo.png" alt="Inventory" class="w-16 h-16 mb-2">
            <div class="font-bold text-orange-600 text-center">Inventory</div>
            <div class="text-xs text-gray-500 text-center">View and update stock levels</div>
        </a>
        <a href="#" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <img src="/images/gemarclogo.png" alt="Orders" class="w-16 h-16 mb-2">
            <div class="font-bold text-green-800 text-center">Order Management</div>
            <div class="text-xs text-gray-500 text-center">Process and track orders</div>
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
