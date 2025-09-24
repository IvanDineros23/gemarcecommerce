    @extends('layouts.app')

@section('content')
<div class="py-8">
    <h1 class="text-3xl font-bold text-green-800 mb-4">Your Cart</h1>
    <div class="bg-white rounded-xl shadow p-6">
        @if($items->isEmpty())
            <p class="text-gray-600">Your cart is empty.</p>
        @else
        <div class="overflow-x-auto">
            <form method="POST" action="{{ route('cart.update') }}">
                @csrf
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
                        <tr class="border-b" x-data="{ qty: {{ $item->qty }}, price: {{ $item->unit_price }} }">
                            <td class="py-2">{{ $item->product->name }}</td>
                            <td class="py-2">₱{{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-2">
                                <input type="number" name="quantities[{{ $item->id }}]" min="1" x-model="qty" class="w-16 border rounded px-2 py-1" @change="$dispatch('update-total')">
                            </td>
                            <td class="py-2" x-text="'₱' + (qty * price).toLocaleString(undefined, {minimumFractionDigits:2})">₱{{ number_format($item->unit_price * $item->qty, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right font-bold text-lg">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mr-2">Update Cart</button>
                    Total: ₱<span id="cart-total">{{ number_format($total, 2) }}</span>
                </div>
            </form>
            @php
                $user = Auth::user();
                $defaultPayment = $user->payment_details['method'] ?? null;
                $defaultDelivery = $user->delivery_option['method'] ?? null;
            @endphp
            <!-- Checkout Options Dropdown -->
            <div x-data="{ open: false }" class="mt-8 max-w-xl mx-auto">
                <button type="button" @click="open = !open" class="w-full flex items-center justify-between bg-gray-100 px-6 py-3 rounded shadow font-semibold text-lg focus:outline-none">
                    <span>Checkout Options</span>
                    <svg :class="{'transform rotate-180': open}" class="h-5 w-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" x-transition class="bg-gray-50 p-6 rounded-b shadow border-t" style="display: none;">
                    <form method="GET" action="{{ route('cart.checkout') }}">
                        <h2 class="text-lg font-semibold mb-4">Checkout Options</h2>
                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                <label class="block font-semibold mb-1">Payment Method</label>
                                <select name="payment_method" class="border rounded px-3 py-2 w-full" required>
                                    <option value="">Select payment method</option>
                                    <option value="cod" @if($defaultPayment=='cod') selected @endif>Cash on Delivery (COD)</option>
                                    <option value="gcash" @if($defaultPayment=='gcash') selected @endif>GCash</option>
                                    <option value="bank" @if($defaultPayment=='bank') selected @endif>Bank Transfer</option>
                                </select>
                                @if($defaultPayment)
                                    <div class="text-xs text-green-700 mt-1">Default: <span class="font-semibold">{{ strtoupper($defaultPayment) }}</span></div>
                                @endif
                            </div>
                            <button type="button" class="ml-2 px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-lg font-bold" title="Add new payment details">+</button>
                        </div>
                        <div class="mb-4 flex items-center justify-between">
                            <div class="w-full">
                                <label class="block font-semibold mb-1">Delivery Method</label>
                                <select name="delivery_method" class="border rounded px-3 py-2 w-full" required>
                                    <option value="">Select delivery method</option>
                                    <option value="pickup" @if($defaultDelivery=='pickup') selected @endif>Pickup</option>
                                    <option value="delivery" @if($defaultDelivery=='delivery') selected @endif>Delivery</option>
                                </select>
                                @if($defaultDelivery)
                                    <div class="text-xs text-green-700 mt-1">Default: <span class="font-semibold">{{ ucfirst($defaultDelivery) }}</span></div>
                                @endif
                            </div>
                            <button type="button" class="ml-2 px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-lg font-bold" title="Add new delivery details">+</button>
                        </div>
                        <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 font-semibold w-full">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
