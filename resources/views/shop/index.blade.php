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
        <div x-data="{ search: '{{ addslashes($q ?? '') }}' }" class="w-full max-w-xl flex gap-2 justify-center">
            <form class="flex gap-2 w-full" method="GET" action="{{ route('shop.index') }}" @submit.prevent="window.location='{{ route('shop.index') }}'+(search ? ('?q='+encodeURIComponent(search)) : '')">
                <input type="text" name="q" x-model="search" class="border border-green-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Search products...">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Search</button>
                <template x-if="search">
                    <button type="button" @click="search=''; window.location='{{ route('shop.index') }}'" class="bg-gray-200 text-gray-700 px-3 py-2 rounded hover:bg-gray-300 font-semibold">Clear</button>
                </template>
            </form>
        </div>
    </div>

    <div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                @php
                    $img = $product->firstImagePath();
                    $imgUrl = $img ? asset('storage/' . $img) : '/images/gemarclogo.png';
                @endphp
                <div
                    class="bg-white rounded-xl shadow flex flex-col h-full min-h-[370px]">

                    <div class="w-full h-40 bg-gray-100 flex items-center justify-center rounded-t-xl overflow-hidden">
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="max-h-36 object-contain">
                    </div>
                    <div class="p-4 flex flex-col flex-1 w-full">
                        <div class="font-bold text-green-800 text-lg mb-1 line-clamp-1">{{ $product->name }}</div>
                        <div class="text-gray-600 text-sm mb-2 line-clamp-2">{{ $product->description }}</div>
                        <div class="mt-auto flex items-center justify-between gap-2">
                            <div class="text-orange-600 font-bold text-lg">₱{{ number_format($product->price,2) }}</div>
                            <div class="flex gap-2">
                                @auth
                                    @php
                                        $alreadySaved = false;
                                        $user = auth()->user();
                                        if ($user) {
                                            $savedListIds = \App\Models\SavedList::where('user_id', $user->id)->pluck('id');
                                            $alreadySaved = \App\Models\SavedListItem::whereIn('saved_list_id', $savedListIds)->where('product_id', $product->id)->exists();
                                        }
                                    @endphp
                                    @if(!$alreadySaved)
                                        <form method="POST" action="{{ route('saved.store') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm font-semibold hover:bg-blue-600" title="Save Product">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5v14l7-7 7 7V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" /></svg>
                                                Save
                                            </button>
                                        </form>
                                    @else
                                        @php
                                            $savedItemId = null;
                                            if ($user) {
                                                $savedItem = \App\Models\SavedListItem::whereIn('saved_list_id', $savedListIds)
                                                    ->where('product_id', $product->id)
                                                    ->first();
                                                $savedItemId = $savedItem ? $savedItem->id : null;
                                            }
                                        @endphp
                                        @if($savedItemId)
                                            <form method="POST" action="{{ route('saved.destroy', $savedItemId) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm font-semibold hover:bg-blue-200" title="Unsave Product">Unsave</button>
                                            </form>
                                        @else
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm font-semibold" title="Already Saved">Saved</span>
                                        @endif
                                    @endif
                                @endauth
                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('cart.add') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm font-semibold hover:bg-green-700">Add to Cart</button>
                                    </form>
                                @else
                                    <span class="bg-gray-400 text-white px-3 py-1 rounded text-sm font-semibold cursor-not-allowed">Out of Stock</span>
                                @endif
                            </div>
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
                            <form method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" :value="modalProduct.id">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-700">Add to Cart</button>
                            </form>
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
