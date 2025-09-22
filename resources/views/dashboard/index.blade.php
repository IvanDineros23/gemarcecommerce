@extends('layouts.app')

@section('content')


{{-- KPIs --}}
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-8">
  @php $cards = [
    ['Open Orders', $kpis['openOrders'] ?? 0, route('orders.index',['status'=>'open']), 'bg-blue-600', 'text-white', '🛒'],
    ['Open Quotes', $kpis['openQuotes'] ?? 0, route('quotes.index',['status'=>'open']), 'bg-yellow-400', 'text-gray-900', '📄'],
    ['In Transit',  $kpis['inTransit'] ?? 0,  route('shipments.index'), 'bg-cyan-500', 'text-white', '🚚'],
    ['Invoices Due','₱'.number_format($kpis['invoicesDue'] ?? 0,2), route('invoices.index',['status'=>'unpaid']), 'bg-red-500', 'text-white', '🧾'],
    ['Backorders',  $kpis['backorders'] ?? 0, route('orders.index',['filter'=>'backorders']), 'bg-gray-500', 'text-white', '⏳']
  ]; @endphp
  @foreach ($cards as [$label, $value, $link, $bg, $text, $emoji])
    <a href="{{ $link }}" class="rounded-xl shadow-md flex flex-col items-center justify-center p-5 transition hover:scale-105 {{ $bg }} {{ $text }}">
      <div class="text-3xl mb-2">{{ $emoji }}</div>
      <div class="uppercase text-xs tracking-wider font-semibold opacity-80">{{ $label }}</div>
      <div class="text-2xl font-bold mt-1">{{ $value }}</div>
    </a>
  @endforeach
</div>


{{-- Quick actions --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
  <a href="{{ route('quick-order.show') }}" class="rounded-xl bg-gray-900 text-white flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-gray-800 transition">Quick Order (SKU)</a>
  <a href="{{ route('bom.upload') }}" class="rounded-xl bg-white border border-gray-300 text-gray-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-gray-100 transition">Upload BOM (CSV/XLSX)</a>
  <a href="{{ route('quotes.create') }}" class="rounded-xl bg-yellow-400 text-gray-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-yellow-300 transition">Start a Quote</a>
  <a href="{{ route('lists.create') }}" class="rounded-xl bg-gray-200 text-gray-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-gray-300 transition">New Saved List</a>
</div>


{{-- Recent Orders & Open Quotes --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
  <div class="bg-white rounded-xl shadow p-0 flex flex-col">
    <div class="px-6 py-4 border-b font-bold text-gray-700 text-lg">Recent Orders</div>
    <ul class="divide-y">
      @forelse ($recentOrders as $o)
        <li class="flex items-center justify-between px-6 py-4">
          <div>
            <div class="font-semibold">#{{ $o->id }} · {{ $o->created_at->format('Y-m-d') }}</div>
            <div class="text-xs text-gray-500">{{ ucfirst($o->status) }}</div>
          </div>
          <div class="text-right">
            <div class="font-semibold text-gray-800">₱{{ number_format($o->total_amount,2) }}</div>
            <div class="flex gap-2 mt-1">
              <a href="{{ route('orders.show',$o) }}" class="text-blue-600 hover:underline text-xs">View</a>
              <a href="{{ route('orders.reorder',$o) }}" class="text-green-600 hover:underline text-xs">Reorder</a>
            </div>
          </div>
        </li>
      @empty
        <li class="px-6 py-4 text-gray-400">No orders yet.</li>
      @endforelse
    </ul>
  </div>
  <div class="bg-white rounded-xl shadow p-0 flex flex-col">
    <div class="px-6 py-4 border-b font-bold text-gray-700 text-lg">Open Quotes</div>
    <ul class="divide-y">
      @forelse ($openQuotes as $q)
        <li class="flex items-center justify-between px-6 py-4">
          <div>
            <div class="font-semibold">Q-{{ $q->id }} · Expires {{ optional($q->expires_at)->format('M d') ?? '—' }}</div>
            <div class="text-xs text-gray-500">{{ $q->items_count ?? $q->items->count() }} items</div>
          </div>
          <div class="flex gap-2">
            <a href="{{ route('quotes.show',$q) }}" class="text-blue-600 hover:underline text-xs">View</a>
            <a href="{{ route('quotes.convert',$q) }}" class="text-indigo-600 hover:underline text-xs">Add to Cart</a>
          </div>
        </li>
      @empty
        <li class="px-6 py-4 text-gray-400">No open quotes.</li>
      @endforelse
    </ul>
  </div>
</div>


{{-- Recommended/Recently Viewed --}}
<div class="mb-8">
  <div class="bg-white rounded-xl shadow">
    <div class="px-6 py-4 border-b font-bold text-gray-700 text-lg">Recommended for You</div>
    <div class="p-6">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
        {{-- Example product cards, replace with real data --}}
        @for ($i = 1; $i <= 4; $i++)
          <div class="bg-gray-50 rounded-lg shadow flex flex-col items-center p-4">
            <img src="https://via.placeholder.com/200x150?text=Product+{{ $i }}" class="rounded mb-2 w-full h-28 object-cover" alt="Product {{ $i }}">
            <div class="font-semibold text-gray-800">Product {{ $i }}</div>
            <div class="text-xs text-gray-500 mb-2">SKU-{{ 1000+$i }}</div>
            <a href="#" class="mt-auto bg-blue-600 text-white rounded px-3 py-1 text-xs font-semibold hover:bg-blue-700 transition">Add to Cart</a>
          </div>
        @endfor
      </div>
    </div>
  </div>
</div>
@endsection
