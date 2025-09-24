@extends('layouts.app')
@section('content')
<style>
[x-cloak] { display: none !important; }
</style>
<div class="max-w-5xl mx-auto py-10" x-data="productModal()">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Product Management</h1>
    @if(session('success') && session('added_product_name'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            <span class="font-semibold">Successfully added a product ({{ session('added_product_name') }})</span>
            <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-green-700 mb-4">Add New Product</h2>
        <form method="POST" action="{{ route('employee.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Description</label>
                <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Price</label>
                <input type="number" name="price" class="w-full border border-gray-300 rounded px-3 py-2" min="0" step="0.01" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Image</label>
                <input type="file" name="image" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Add Product</button>
        </form>
    </div>

    <!-- Edit Product Modal -->
    <div x-show="show" x-transition.opacity x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        @keydown.window.escape="close()"
        @click.self="close()">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative" @click.stop>
            <button @click="close" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-orange-600 mb-4">Edit Product</h2>
            <form :action="updateUrl" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" :value="csrf">
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Product Name</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" x-model="form.name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Description</label>
                    <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" x-model="form.description" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Price</label>
                    <input type="number" name="price" class="w-full border border-gray-300 rounded px-3 py-2" min="0" step="0.01" x-model="form.price" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded px-3 py-2">
                    <template x-if="form.image">
                        <img :src="form.image" alt="Product Image" class="w-16 h-16 object-cover rounded mt-2">
                    </template>
                </div>
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Update Product</button>
            </form>
        </div>
    </div>
    <script>
    function productModal() {
        return {
            show: false,
            form: { name: '', description: '', price: '', image: '' },
            updateUrl: '',
            csrf: '{{ csrf_token() }}',
            showDelete: false,
            deleteProduct: { id: null, name: '' },
            open(product) {
                this.form.name = product.name;
                this.form.description = product.description;
                this.form.price = product.price;
                this.form.image = product.image_url || '';
                this.updateUrl = product.update_url;
                this.show = true;
            },
            close() {
                this.show = false;
            },
            openDelete(product) {
                this.deleteProduct = product;
                this.showDelete = true;
            },
            closeDelete() {
                this.showDelete = false;
                this.deleteProduct = { id: null, name: '' };
            },
            confirmDelete() {
                if (this.deleteProduct.id) {
                    document.getElementById('deleteForm' + this.deleteProduct.id).submit();
                }
                this.closeDelete();
            }
        }
    }
    </script>
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold text-green-700 mb-4">All Products</h2>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">Name</th>
                    <th class="py-2">Description</th>
                    <th class="py-2">Price</th>
                    <th class="py-2">Image</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b">
                    <td class="py-2">{{ $product->name }}</td>
                    <td class="py-2">{{ $product->description }}</td>
                    <td class="py-2">₱{{ number_format($product->price, 2) }}</td>
                    <td class="py-2">
                        @php $img = $product->firstImagePath(); @endphp
                        @if($img)
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </td>
                    <td class="py-2">
                        <button type="button" class="text-blue-600 hover:underline mr-2" @click="open({
                            name: '{{ $product->name }}',
                            description: `{{ str_replace('`', '\`', $product->description) }}`,
                            price: '{{ $product->price }}',
                            image_url: '{{ $img ? asset('storage/' . $img) : '' }}',
                            update_url: '{{ route('employee.products.update', $product) }}'
                        })">Edit</button>
                        <form :id="'deleteForm' + {{ $product->id }}" action="{{ route('employee.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-600 hover:underline" @click="openDelete({ id: {{ $product->id }}, name: '{{ $product->name }}' })">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
<!-- Delete Confirmation Modal -->
<div x-show="showDelete" x-transition.opacity x-cloak class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" @keydown.window.escape="closeDelete()" @click.self="closeDelete()">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative" @click.stop>
        <button @click="closeDelete" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl">&times;</button>
        <h2 class="text-xl font-bold text-red-600 mb-4">Delete Product</h2>
        <p class="mb-6">Are you sure you want to delete <span class="font-semibold" x-text="deleteProduct.name"></span>? This action cannot be undone.</p>
        <div class="flex justify-end gap-4">
            <button @click="closeDelete" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancel</button>
            <button @click="confirmDelete" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 font-semibold">Yes, Delete</button>
        </div>
    </div>
</div>
</div>
</div>
@endsection
