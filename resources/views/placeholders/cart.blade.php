@extends('layouts.app')

@section('content')
<div class="py-8">
    <h1 class="text-3xl font-bold text-green-800 mb-4">Your Cart</h1>
    <div class="bg-white rounded-xl shadow p-6">
        @if($items->isEmpty())
            <p class="text-gray-600">Your cart is empty.</p>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm mb-4">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Product</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Quantity</th>
                        <th class="py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->product->name }}</td>
                        <td class="py-2">₱{{ number_format($item->product->price, 2) }}</td>
                        <td class="py-2">{{ $item->quantity }}</td>
                        <td class="py-2">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right font-bold text-lg">Total: ₱{{ number_format($total, 2) }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
