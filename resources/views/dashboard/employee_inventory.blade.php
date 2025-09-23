@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-orange-700 mb-6">Inventory Management</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <table class="min-w-full text-sm">
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
@endsection
