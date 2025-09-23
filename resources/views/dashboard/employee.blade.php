@extends('layouts.app')

@section('content')
<div class="py-8">
    <!-- Analytics Charts -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="font-bold text-green-800 mb-2">Stock Levels</div>
            <canvas id="stockLevelsChart" height="80" style="max-width: 100%; max-height: 220px;"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
            <div class="font-bold text-green-800 mb-2">Inventory Value</div>
            <canvas id="inventoryValueChart" height="80" style="max-width: 100%; max-height: 220px;"></canvas>
        </div>
    </div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Employee Dashboard</h1>
            <p class="text-gray-700">Welcome, {{ auth()->user()->name }}! Manage products, inventory, and orders here.</p>
        </div>
    </div>
    <div class="w-full flex flex-col md:flex-row gap-4 mb-8">
        <a href="{{ route('employee.products.index') }}" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <!-- Modern Product Icon -->
            <svg class="w-16 h-16 mb-2 text-green-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="7" width="18" height="13" rx="2" fill="#e0f2fe"/>
                <path d="M3 7V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v2" stroke="#38bdf8" stroke-width="1.5"/>
                <circle cx="8" cy="13" r="2" fill="#38bdf8"/>
                <rect x="12" y="11" width="6" height="4" rx="1" fill="#bae6fd"/>
            </svg>
            <div class="font-bold text-green-800 text-center">Product Management</div>
            <div class="text-xs text-gray-500 text-center">Add, edit, or remove products</div>
        </a>
    <a href="{{ route('employee.inventory.index') }}" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <!-- Modern Inventory Icon -->
            <svg class="w-16 h-16 mb-2 text-orange-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="4" y="8" width="16" height="10" rx="2" fill="#fef9c3"/>
                <path d="M4 8V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2" stroke="#f59e42" stroke-width="1.5"/>
                <rect x="8" y="12" width="8" height="2" rx="1" fill="#fde68a"/>
            </svg>
            <div class="font-bold text-orange-600 text-center">Inventory</div>
            <div class="text-xs text-gray-500 text-center">View and update stock levels</div>
        </a>
        <a href="#" class="flex-1 max-w-xs bg-white rounded-xl shadow p-4 flex flex-col items-center hover:bg-green-50 transition mx-auto md:mx-0">
            <!-- Modern Order Management Icon -->
            <svg class="w-16 h-16 mb-2 text-green-800" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="4" y="6" width="16" height="12" rx="2" fill="#bbf7d0"/>
                <path d="M8 10h8M8 14h5" stroke="#22c55e" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="18" cy="18" r="3" fill="#22c55e"/>
                <path d="M18 16v2l1 1" stroke="#fff" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            <div class="font-bold text-green-800 text-center">Order Management</div>
            <div class="text-xs text-gray-500 text-center">Process and track orders</div>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-lg font-bold text-green-800 mb-2">Messages & Notifications</div>
        <ul class="divide-y">
            @forelse ($notifications as $notif)
                <li class="flex items-center justify-between py-4">
                    <div>
                        @if ($notif->type === 'chat')
                            <div class="font-semibold">{{ $notif->user }}</div>
                            <div class="text-xs text-gray-500">{{ $notif->created_at->format('Y-m-d H:i') }}</div>
                            <div class="mt-1">{{ $notif->message }}</div>
                        @elseif ($notif->type === 'cart')
                            <div class="font-semibold text-orange-700">Add to Cart Activity</div>
                            <div class="text-xs text-gray-500">{{ $notif->created_at->format('Y-m-d H:i') }}</div>
                            <div class="mt-1">{{ $notif->user }} added <b>{{ $notif->qty }}</b> of <b>{{ $notif->product }}</b> to cart.</div>
                        @endif
                    </div>
                </li>
            @empty
                <li class="py-4 text-gray-400">No messages or notifications yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Chart) {
        // Example data, replace with real data from backend if needed
        const stockLabels = @json(\App\Models\Product::pluck('name'));
        const stockData = @json(\App\Models\Product::pluck('stock'));
        const valueData = @json(\App\Models\Product::all()->map(fn($p) => $p->stock * $p->price));

        new Chart(document.getElementById('stockLevelsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: stockLabels,
                datasets: [{
                    label: 'Stock',
                    data: stockData,
                    backgroundColor: '#38bdf8',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        new Chart(document.getElementById('inventoryValueChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: stockLabels,
                datasets: [{
                    label: 'Inventory Value',
                    data: valueData,
                    backgroundColor: ['#22c55e', '#38bdf8', '#f59e42', '#bbf7d0', '#fde68a', '#e0f2fe'],
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }
});
</script>
@endpush
@endsection
