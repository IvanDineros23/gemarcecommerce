@extends('layouts.app')
@section('title', 'My Orders | Gemarc Enterprises Inc.')
@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold text-green-800 mb-4">My Orders</h1>
        @if(session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if($orders->isEmpty())
            <div class="text-gray-600">You have no orders yet.</div>
        @else
        <table class="w-full text-sm mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-3 text-left">Reference #</th>
                    <th class="py-2 px-3 text-left">Date</th>
                    <th class="py-2 px-3 text-right">Total</th>
                    <th class="py-2 px-3 text-center">Status</th>
                    <th class="py-2 px-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td class="py-2 px-3">{{ $order->reference_number }}</td>
                    <td class="py-2 px-3">{{ $order->created_at->format('F d, Y h:i A') }}</td>
                    <td class="py-2 px-3 text-right">₱{{ number_format($order->total_amount, 2) }}</td>
                    <td class="py-2 px-3 text-center">{{ ucfirst($order->status) }}</td>
                    <td class="py-2 px-3 text-center">
                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
