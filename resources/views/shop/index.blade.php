@section('title', 'All Products | Gemarc Enterprises Inc.')
@extends('layouts.app')

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>[x-cloak]{display:none!important}</style>
<script>
function productModal() {
    return {
        show: false,
        modalProduct: { name: '', price: 0, description: '', image: '' },
        openModal(product) {
            this.modalProduct = product;
            this.show = true;
        },
        close(){ this.show = false; }
    }
}
</script>
@endpush

@section('content')
<div class="py-8">
    <div class="flex flex-col items-center justify-center mb-8">
        <h1 class="text-3xl font-bold text-green-800 mb-2">Shop All Products</h1>
        <p class="text-gray-700 mb-4">Browse all products offered by <span class="text-orange-600 font-semibold">Gemarc Enterprises Inc.</span></p>
        <form class="w-full max-w-xl flex gap-2 justify-center">
            <input type="text" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Search products...">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Search</button>
        </form>
    </div>

    <div x-data="productModal()"
         @open-product.window="openModal($event.detail)"
         @keydown.escape.window="close()">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                @php
                    $img = $product->firstImagePath();
                    $imgUrl = $img ? asset('storage/' . $img) : '/images/gemarclogo.png';
                @endphp
                <div
                    class="bg-white rounded-xl shadow flex flex-col h-full min-h-[370px] cursor-pointer"
                    x-data="{ name: @js($product->name), price: @js($product->price), description: @js($product->description), image: @js($imgUrl), stock: @js($product->stock) }"
                    @click="$dispatch('open-product', { name, price, description, image, stock })">

                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center rounded-t-xl overflow-hidden">
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="max-h-36 object-contain">
                    </div>
                    <div class="p-4 flex flex-col flex-1 w-full">
                        <div class="font-bold text-green-800 text-lg mb-1 line-clamp-1">{{ $product->name }}</div>
                        <div class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $product->description }}</div>
                        <div class="mt-auto flex items-center justify-between">
                            <div class="text-orange-600 font-bold text-lg">₱{{ number_format($product->price,2) }}</div>
                            @if($product->stock > 0)
                                <span class="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold">Add to Cart</span>
                            @else
                                <span class="bg-gray-400 text-white px-3 py-1 rounded text-sm font-semibold cursor-not-allowed">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-12">No products found.</div>
            @endforelse
        </div>

        <div x-cloak x-show="show" x-transition
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-xl shadow-lg max-w-lg w-full p-6 relative">
                <button @click="close()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <div class="flex flex-col items-center">
                    <img :src="modalProduct.image" alt="" class="mb-4 rounded max-h-48 object-contain bg-gray-100 w-full">
                    <div class="font-bold text-green-800 text-2xl mb-2" x-text="modalProduct.name"></div>
                    <div class="text-orange-600 font-bold text-xl mb-2"
                         x-text="'₱' + Number(modalProduct.price).toLocaleString(undefined, {minimumFractionDigits:2})"></div>
                    <div class="text-gray-700 mb-4 text-center" x-text="modalProduct.description"></div>
                    <div class="flex gap-2">
                        <template x-if="modalProduct.stock > 0">
                            <button class="bg-green-600 text-white px-4 py-2 rounded font-semibold">Add to Cart</button>
                        </template>
                        <template x-if="modalProduct.stock == 0">
                            <button class="bg-gray-400 text-white px-4 py-2 rounded font-semibold cursor-not-allowed" disabled>Out of Stock</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-8 text-sm text-gray-500 text-center">
        <span class="text-green-800 font-semibold">Gemarc Enterprises Inc.</span> is an authorized distributor of select partner brands. All products are curated for quality and reliability.
    </div>
</div>
@endsection
