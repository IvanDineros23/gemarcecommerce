@extends('layouts.app')

@section('content')
<div class="py-8">
    <!-- Search Bar -->
    <!-- Removed duplicate search bar -->
    <div class="flex flex-col items-center justify-center mb-8">
        <form x-data="searchBar()" @submit.prevent="onSearch" class="w-full max-w-2xl flex flex-col items-center">
            <div class="relative w-full flex items-center">
                <input type="text" x-model="query" @focus="showSuggestions = true" @input="onInput" @keydown.escape="showSuggestions = false" placeholder="Search products, orders, etc..." class="w-full border border-green-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 text-lg" autocomplete="off">
                <button type="button" x-show="query.length" @click="clearQuery" class="absolute right-20 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <button type="submit" class="ml-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded transition">Search</button>
                <div x-show="showSuggestions && (suggestions.length || recent.length)" @mousedown.away="showSuggestions = false" class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-200 rounded shadow z-20">
                    <template x-if="recent.length">
                        <div class="px-4 py-2 text-xs text-gray-500 border-b">Recent Searches</div>
                    </template>
                    <template x-for="item in recent" :key="item">
                        <div @click="selectSuggestion(item)" class="px-4 py-2 cursor-pointer hover:bg-orange-50">@{{ item }}</div>
                    </template>
                    <template x-if="suggestions.length">
                        <div class="px-4 py-2 text-xs text-gray-500 border-b">Product Suggestions</div>
                    </template>
                    <template x-for="item in suggestions" :key="item">
                        <div @click="selectSuggestion(item)" class="px-4 py-2 cursor-pointer hover:bg-orange-50">@{{ item }}</div>
                    </template>
                </div>
            </div>
        </form>
        <div class="mt-6 text-center">
            <h1 class="text-3xl font-bold text-green-800 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-700">Browse and request products from <span class="text-orange-600 font-semibold">Gemarc Enterprises Inc.</span></p>
        </div>
        <a href="{{ route('shop.index') }}" class="mt-4 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded shadow transition">Shop All Products</a>
    </div>
@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function searchBar() {
    return {
        query: '',
        showSuggestions: false,
        recent: JSON.parse(localStorage.getItem('recentSearches') || '[]'),
        suggestions: [],
        onInput() {
            // Simulate product suggestions (replace with AJAX in production)
            const allProducts = [
                @foreach($recommendedProducts ?? [] as $p)
                    @json($p->name),
                @endforeach
                'Ceramic Muffle Furnace', 'Nemo cupiditate deserunt', 'Cum cumque nam', 'Et sapiente eaque', 'Sunt a non', 'Nesciunt dolor delectus', 'Fugiat sunt mollitia', 'Quia architecto et'
            ];
            this.suggestions = allProducts.filter(p => p.toLowerCase().includes(this.query.toLowerCase()) && this.query.length > 0).slice(0, 5);
        },
        onSearch() {
            if (this.query.trim()) {
                this.recent = [this.query, ...this.recent.filter(q => q !== this.query)].slice(0, 5);
                localStorage.setItem('recentSearches', JSON.stringify(this.recent));
                // Optionally redirect or trigger search
                window.location.href = '/shop?search=' + encodeURIComponent(this.query);
            }
        },
        selectSuggestion(item) {
            this.query = item;
            this.showSuggestions = false;
            this.onSearch();
        },
        clearQuery() {
            this.query = '';
            this.suggestions = [];
        }
    }
}
</script>
@endpush
    <!-- ...existing code... -->
        <div class="flex flex-col md:flex-row gap-6 mb-8">
        <!-- Create/Request Quote -->
                <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                    <div class="text-lg font-bold text-green-800 mb-2 flex items-center gap-2">📝 Request a Quote</div>
                    <a href="{{ route('quotes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold w-max">Create Quote</a>
        </div>
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow p-6 flex flex-col">
            <div class="text-lg font-bold text-green-800 mb-2">Your Recent Orders</div>
            <ul class="divide-y">
                @forelse ($recentOrders as $o)
                    <li class="flex items-center justify-between py-4">
                        <div>
                            <div class="font-semibold">#{{ $o->id }} · {{ $o->created_at->format('Y-m-d') }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($o->status) }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-800">₱{{ number_format($o->total_amount,2) }}</div>
                            <a href="{{ route('orders.show',$o) }}" class="text-green-700 hover:underline text-xs ml-2">View</a>
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-gray-400">No orders yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-lg font-bold text-orange-600 mb-2">Recommended for You</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse ($recommendedProducts as $product)
                <div class="bg-gray-50 rounded-xl shadow flex flex-col items-center p-2 min-h-[120px]">
                    @php $img = $product->firstImagePath(); @endphp
                    @if($img)
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="mb-1 rounded max-h-20 object-contain">
                    @else
                        <img src="/images/gemarclogo.png" alt="No Image" class="mb-1 rounded max-h-20 object-contain">
                    @endif
                    <div class="font-semibold text-green-900 text-xs text-center line-clamp-2">{{ $product->name }}</div>
                    <div class="text-orange-600 font-bold text-xs">₱{{ number_format($product->price,2) }}</div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-8">No recommended products.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
