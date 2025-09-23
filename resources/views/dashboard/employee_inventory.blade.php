@extends('layouts.app')
@section('title', 'Inventory Management | Gemarc Enterprises Inc.')
@section('content')
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-orange-700 mb-6">Inventory Management</h1>
    <div class="mb-4">
        <input type="text" id="inventory-search" placeholder="Search item..." class="border border-gray-300 rounded px-3 py-2 w-full max-w-md focus:outline-none focus:ring-2 focus:ring-orange-400" onkeyup="filterInventoryTable()">
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full text-sm" id="inventory-table">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Name</th>
                    <th class="py-2">Stock</th>
                    <th class="py-2">Update Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="py-2">{{ $product->name }}</td>
                    <td class="py-2">{{ $product->stock }}</td>
                    <td class="py-2">
                        <form method="POST" action="{{ route('employee.inventory.update', $product) }}" class="flex gap-2 items-center">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="border rounded px-2 py-1 w-20">
                            <button type="submit" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-800">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
function filterInventoryTable() {
    const input = document.getElementById('inventory-search');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('inventory-table');
    const trs = table.getElementsByTagName('tr');
    for (let i = 1; i < trs.length; i++) { // skip header
        const td = trs[i].getElementsByTagName('td')[0];
        if (td) {
            const txtValue = td.textContent || td.innerText;
            trs[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
        }
    }
}
</script>
@endpush
@endsection
