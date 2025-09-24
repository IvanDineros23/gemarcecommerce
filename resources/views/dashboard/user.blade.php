@extends('layouts.app')
@section('content')
<div class="py-8">
    <!-- Search Bar -->
    <!-- Removed duplicate search bar -->
    <div class="flex flex-col items-center justify-center mb-8">
        <form x-data="searchBar()" @submit.prevent="onSearch" class="w-full max-w-2xl flex flex-col items-center">
            <div class="relative w-full flex items-center" style="max-width: 600px;">
                <input type="text" x-model="query" @focus="showSuggestions = true" @input="onInput" @keydown.escape="showSuggestions = false" placeholder="Search products, orders, etc..." class="w-full border border-green-300 rounded px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-orange-400 text-lg" autocomplete="off" style="position:relative;">
                <button type="button" x-show="query.length" @click="clearQuery" class="absolute right-28 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none bg-transparent p-2" style="z-index:2;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <button type="submit" class="ml-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded transition">Search</button>
                <div x-show="showSuggestions && (suggestions.length || recent.length)" @mousedown.away="showSuggestions = false" class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-200 rounded shadow z-20" style="max-width:600px;">
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
                        <div @click="selectSuggestion(item)" class="px-4 py-2 cursor-pointer hover:bg-orange-50" x-text="item"></div>
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
<style>
    .relative.w-full.flex.items-center {
        max-width: 600px;
    }
    .relative.w-full.flex.items-center input {
        padding-right: 2.5rem;
    }
    .relative.w-full.flex.items-center .clear-btn {
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
        position: absolute;
        z-index: 2;
    }
    .relative.w-full.flex.items-center .absolute.left-0.top-full.mt-1.w-full.bg-white {
        max-width: 600px;
        left: 0;
        right: 0;
    }
    @media (max-width: 700px) {
        .relative.w-full.flex.items-center {
            max-width: 100%;
        }
        .relative.w-full.flex.items-center .absolute.left-0.top-full.mt-1.w-full.bg-white {
            max-width: 100%;
        }
    }
</style>
@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function searchBar() {
    return {
        query: '',
        showSuggestions: false,
        recent: JSON.parse(localStorage.getItem('recentSearches') || '[]'),
        suggestions: [],
        allProducts: [
            @foreach(\App\Models\Product::where('is_active', true)->pluck('name') as $p)
                @json($p),
            @endforeach
        ],
        onInput() {
            this.suggestions = this.allProducts.filter(p => p.toLowerCase().includes(this.query.toLowerCase()) && this.query.length > 0).slice(0, 5);
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
    <!-- Centered Request a Quote and Recent Orders section -->
    <div class="flex flex-col items-center justify-center w-full mb-8">
        <div class="flex flex-col md:flex-row gap-6 w-full max-w-4xl justify-center">
            <!-- Create/Request Quote -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col flex-1 min-w-[260px] max-w-[350px] items-center">
                <div class="text-lg font-bold text-green-800 mb-2 flex items-center gap-2">📝 Request a Quote</div>
                <a href="{{ route('quotes.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded font-semibold w-max">Create Quote</a>
            </div>
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow p-6 flex flex-col flex-1 min-w-[260px] max-w-[350px] items-center">
                <div class="text-lg font-bold text-green-800 mb-2">Your Recent Orders</div>
                <ul class="divide-y w-full">
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
<!-- Footer Styles -->
<style>
    .footer {
        background: #f8f9fa;
        padding: 32px 0 0 0;
        margin-top: 32px;
        font-family: 'Inter', Arial, sans-serif;
        box-shadow: 0 -2px 8px rgba(0,0,0,0.04);
    }
    .footer .container {
        width: 100%;
        margin: 0;
        padding: 0;
    }
    .footer-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 24px;
        width: 100%;
    }
    .footer-section {
        flex: 1 1 0;
        min-width: 220px;
        background: transparent;
        border-radius: 0;
        box-shadow: none;
        padding: 0 20px 0 32px;
        margin-bottom: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .footer-section h4 {
        color: #198754;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: none;
    }
    .footer-section h4 i {
        color: #ff8800;
        font-size: 1.2rem;
    }
    .footer-section p {
        color: #333;
        font-size: 1rem;
        margin: 0;
        line-height: 1.5;
    }
    .footer-bottom {
        text-align: center;
        padding: 18px 0 8px 0;
        color: #fff;
        background: linear-gradient(90deg, #198754 60%, #ff8800 100%);
        border-radius: 0 0 12px 12px;
        font-size: 1rem;
        font-weight: 500;
        margin-top: 0;
    }
    @media (max-width: 900px) {
        .footer-content {
            flex-direction: column;
            gap: 18px;
        }
        .footer-section {
            min-width: 0;
            padding: 0 12px;
        }
    }
</style>
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4><i class="fas fa-map-marker-alt"></i> Office Address</h4>
                <p>No. 15 Chile St. Ph1 Greenheights Subdivision, Concepcion 1, Marikina City, Philippines 1807</p>
            </div>
            <div class="footer-section">
                <h4><i class="fas fa-phone"></i> Telephone Numbers</h4>
                <p>(632)8-997-7959 | (632)8-584-5572</p>
            </div>
            <div class="footer-section">
                <h4><i class="fas fa-mobile-alt"></i> Mobile Numbers</h4>
                <p>+63 909 087 9416<br>+63 928 395 3532 | +63 918 905 8316</p>
            </div>
            <div class="footer-section">
                <h4><i class="fas fa-envelope"></i> Email Address</h4>
                <p>sales@gemarcph.com<br>technical@gemarcph.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Gemarc Enterprises Incorporated. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection
