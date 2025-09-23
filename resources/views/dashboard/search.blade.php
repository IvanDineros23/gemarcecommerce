@extends('layouts.app')

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-green-800 mb-4">Search Results</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <div class="text-gray-700 mb-2">You searched for:</div>
        <div class="text-lg font-semibold text-orange-600 mb-4">{{ $q }}</div>
        <div class="text-gray-400">(Demo only: Implement real search logic here.)</div>
    </div>
</div>
@endsection
