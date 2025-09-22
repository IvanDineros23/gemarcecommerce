@extends('layouts.app')

@section('content')
<div class="container py-4">
  {{-- KPIs --}}
  <div class="row g-3 mb-3">
    @php $cards = [
      ['Open Orders', $kpis['openOrders'] ?? 0, route('orders.index',['status'=>'open'])],
      ['Open Quotes', $kpis['openQuotes'] ?? 0, route('quotes.index',['status'=>'open'])],
      ['In Transit',  $kpis['inTransit'] ?? 0,  route('shipments.index')],
      ['Invoices Due','₱'.number_format($kpis['invoicesDue'] ?? 0,2), route('invoices.index',['status'=>'unpaid'])],
      ['Backorders',  $kpis['backorders'] ?? 0, route('orders.index',['filter'=>'backorders'])]
    ]; @endphp
    @foreach ($cards as [$label, $value, $link])
      <div class="col-6 col-md-4 col-lg-2">
        <a href="{{ $link }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <div class="text-muted small">{{ $label }}</div>
              <div class="h4 mb-0 fw-bold">{{ $value }}</div>
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
  {{-- Quick actions --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3"><a href="{{ route('quick-order.show') }}" class="btn btn-dark w-100">Quick Order (SKU)</a></div>
    <div class="col-md-3"><a href="{{ route('bom.upload') }}" class="btn btn-outline-dark w-100">Upload BOM (CSV/XLSX)</a></div>
    <div class="col-md-3"><a href="{{ route('quotes.create') }}" class="btn btn-warning w-100">Start a Quote</a></div>
    <div class="col-md-3"><a href="{{ route('lists.create') }}" class="btn btn-outline-secondary w-100">New Saved List</a></div>
  </div>
  {{-- Two-column lists --}}
  <div class="row g-4">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Recent Orders</div>
        <ul class="list-group list-group-flush">
          @forelse ($recentOrders as $o)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">#{{ $o->id }} · {{ $o->created_at->format('Y-m-d') }}</div>
                <div class="small text-muted">{{ ucfirst($o->status) }}</div>
              </div>
              <div class="text-end">
                <div class="fw-semibold">₱{{ number_format($o->total_amount,2) }}</div>
                <a href="{{ route('orders.show',$o) }}" class="small">View</a>
              </div>
            </li>
          @empty
            <li class="list-group-item text-muted">No orders yet.</li>
          @endforelse
        </ul>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Open Quotes</div>
        <ul class="list-group list-group-flush">
          @forelse ($openQuotes as $q)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">Q-{{ $q->id }} · Expires {{ optional($q->expires_at)->format('M d') ?? '—' }}</div>
                <div class="small text-muted">{{ $q->items_count ?? $q->items->count() }} items</div>
              </div>
              <div>
                <a href="{{ route('quotes.show',$q) }}" class="btn btn-sm btn-outline-secondary">View</a>
                <a href="{{ route('quotes.convert',$q) }}" class="btn btn-sm btn-primary">Add to Cart</a>
              </div>
            </li>
          @empty
            <li class="list-group-item text-muted">No open quotes.</li>
          @endforelse
        </ul>
      </div>
    </div>
    {{-- Add more cards: shipments, saved lists, active carts, recommendations --}}
  </div>
</div>
@endsection
