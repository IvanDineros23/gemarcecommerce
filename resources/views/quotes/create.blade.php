@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Request a Quote</h1>
    <form method="GET" action="" class="mb-4" onsubmit="return false;">
        <div class="flex gap-2">
            <input type="text" id="product-search" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-200" autocomplete="off" />
            <button type="button" id="clear-search" class="bg-gray-200 px-3 rounded text-gray-700 font-semibold hover:bg-gray-300">Clear</button>
        </div>
    </form>
    <form method="POST" action="{{ route('quotes.store') }}">
        @csrf
        <div class="mb-6 overflow-x-auto">
            <table class="min-w-full bg-white border rounded shadow" id="products-table">
                <thead>
                    <tr class="bg-green-100 text-green-800">
                        <th class="px-4 py-2 text-left">Image</th>
                        <th class="px-4 py-2 text-left">Product</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-right">Price</th>
                        <th class="px-4 py-2 text-center">Quantity</th>
                        <th class="px-4 py-2 text-center">Add</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="product-row">
                        <td class="px-4 py-2 text-center">
                            @php
                                $img = null;
                                if (isset($product->images) && count($product->images)) {
                                    $img = $product->images->first()->path ?? null;
                                } elseif (!empty($product->image)) {
                                    $img = $product->image;
                                }
                            @endphp
                            @if($img)
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-16 h-16 object-contain rounded border" />
                            @else
                                <div class="w-16 h-16 flex items-center justify-center bg-gray-100 text-gray-400 border rounded">No Image</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 product-name">{{ $product->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-600 product-desc">{{ $product->description }}</td>
                        <td class="px-4 py-2 text-right">₱{{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2 text-center">
                            <input type="number" name="quantities[{{ $product->id }}]" min="0" max="9999" value="0" class="w-20 border rounded px-2 py-1 text-center">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Additional Notes</label>
            <textarea name="notes" class="w-full border border-gray-300 rounded px-3 py-2" rows="3" placeholder="Any special instructions or notes..."></textarea>
        </div>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Submit Quote Request</button>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('product-search');
    const clearBtn = document.getElementById('clear-search');
    const rows = document.querySelectorAll('.product-row');
    function filterRows() {
        const val = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const name = row.querySelector('.product-name').textContent.toLowerCase();
            const desc = row.querySelector('.product-desc').textContent.toLowerCase();
            if (name.includes(val) || desc.includes(val)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    searchInput.addEventListener('input', filterRows);
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterRows();
        searchInput.focus();
    });
});
</script>
@endpush
@endsection
