@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-3">Products</h1>
  <div class="row">
    @foreach ($products as $p)
      <div class="col-md-3 mb-3">
        <div class="card h-100">
          <img class="card-img-top" src="{{ asset('storage/'.$p->id.'.jpg') }}" onerror="this.src='https://picsum.photos/seed/{{ $p->id }}/400/300';">
          <div class="card-body">
            <h6 class="card-title mb-1">{{ $p->name }}</h6>
            <div class="small text-muted">₱{{ number_format($p->price,2) }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $products->links() }}
</div>
@endsection
