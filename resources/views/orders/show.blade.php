@extends('layouts.app')
@section('title', 'Order Details | Gemarc Enterprises Inc.')
@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold text-green-800 mb-4">Order Details</h1>
        <div class="mb-4">
            <div class="text-gray-700 mb-2">Reference #: <span class="font-semibold">{{ $order->reference_number }}</span></div>
            <div class="text-gray-700 mb-2">Order Date: <span class="font-semibold">{{ $order->created_at->format('F d, Y h:i A') }}</span></div>
            <div class="text-gray-700 mb-2">Status: <span class="font-semibold">{{ ucfirst($order->status) }}</span></div>
        </div>
        <table class="w-full mb-6 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3 text-left">Product</th>
                    <th class="py-2 px-3 text-right">Qty</th>
                    <th class="py-2 px-3 text-right">Unit Price</th>
                    <th class="py-2 px-3 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="py-2 px-3">{{ $item->name }}</td>
                        <td class="py-2 px-3 text-right">{{ $item->qty }}</td>
                        <td class="py-2 px-3 text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-2 px-3 text-right">₱{{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td colspan="3" class="py-2 px-3 text-right">Total</td>
                    <td class="py-2 px-3 text-right">₱{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        <a href="{{ route('orders.index') }}" class="bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-700">Back to My Orders</a>
    </div>
</div>
@endsection
