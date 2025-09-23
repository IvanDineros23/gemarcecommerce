@extends('layouts.app')

@section('content')
<div class="py-6">
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-8">
    @php $cards = [
      ['Open Orders', $kpis['openOrders'] ?? 0, route('orders.index',['status'=>'open']), 'bg-green-700', 'text-white', '🛒'],
      ['Open Quotes', $kpis['openQuotes'] ?? 0, route('quotes.index',['status'=>'open']), 'bg-orange-400', 'text-gray-900', '📄'],
      ['In Transit',  $kpis['inTransit'] ?? 0,  route('shipments.index'), 'bg-green-500', 'text-white', '🚚'],
      ['Invoices Due','₱'.number_format($kpis['invoicesDue'] ?? 0,2), route('invoices.index',['status'=>'unpaid']), 'bg-orange-600', 'text-white', '🧾'],
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

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('quick-order.show') }}" class="rounded-xl bg-green-900 text-white flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-green-800 transition">Quick Order (SKU)</a>
    <a href="{{ route('bom.upload') }}" class="rounded-xl bg-white border border-green-300 text-green-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-green-100 transition">Upload BOM (CSV/XLSX)</a>
    <a href="{{ route('quotes.create') }}" class="rounded-xl bg-orange-400 text-gray-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-orange-300 transition">Start a Quote</a>
    <a href="{{ route('lists.create') }}" class="rounded-xl bg-gray-200 text-gray-900 flex flex-col items-center justify-center py-6 px-4 text-lg font-semibold shadow hover:bg-gray-300 transition">New Saved List</a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-0 flex flex-col">
      <div class="px-6 py-4 border-b font-bold text-green-700 text-lg">Recent Orders</div>
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
                <a href="{{ route('orders.show',$o) }}" class="text-green-700 hover:underline text-xs">View</a>
                <a href="{{ route('orders.reorder',$o) }}" class="text-orange-600 hover:underline text-xs">Reorder</a>
              </div>
            </div>
          </li>
        @empty
          <li class="px-6 py-4 text-gray-400">No orders yet.</li>
        @endforelse
      </ul>
    </div>
    <div class="bg-white rounded-xl shadow p-0 flex flex-col">
      <div class="px-6 py-4 border-b font-bold text-orange-600 text-lg">Open Quotes</div>
      <ul class="divide-y">
        @forelse ($openQuotes as $q)
          <li class="flex items-center justify-between px-6 py-4">
            <div>
              <div class="font-semibold">#{{ $q->id }} · {{ $q->created_at->format('Y-m-d') }}</div>
              <div class="text-xs text-gray-500">{{ ucfirst($q->status) }}</div>
            </div>
            <div class="text-right">
              <div class="font-semibold text-gray-800">₱{{ number_format($q->total_amount,2) }}</div>
              <div class="flex gap-2 mt-1">
                <a href="{{ route('quotes.show',$q) }}" class="text-green-700 hover:underline text-xs">View</a>
                <a href="{{ route('quotes.reorder',$q) }}" class="text-orange-600 hover:underline text-xs">Reorder</a>
              </div>
            </div>
          </li>
        @empty
          <li class="px-6 py-4 text-gray-400">No open quotes.</li>
        @endforelse
      </ul>
    </div>
  </div>

  <div class="mt-8">
    <div class="text-lg font-bold text-green-800 mb-2">Recommended for You</div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @for ($i = 1; $i <= 4; $i++)
        <div class="bg-white rounded-xl shadow flex flex-col items-center p-4">
          <img src="https://via.placeholder.com/120x80?text=Product+{{ $i }}" alt="Product {{ $i }}" class="mb-2 rounded">
          <div class="font-semibold text-green-900">Product {{ $i }}</div>
        </div>
      @endfor
    </div>
  </div>

  <div class="flex justify-end mb-6">
    <a href="{{ route('shop.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded shadow transition">Shop All Products</a>
  </div>
</div>
@endsection
