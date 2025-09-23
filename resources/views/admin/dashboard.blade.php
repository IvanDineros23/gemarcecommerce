{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
        <div class="admin-title mb-2 text-green-800 text-xl font-bold">Orders & Quotes</div>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.orders') }}" class="admin-link">All Orders</a></li>
            <li><a href="{{ route('admin.quotes') }}" class="admin-link">Quotes Management</a></li>
            <li><a href="{{ route('admin.uploads') }}" class="admin-link">Bulk Uploads (CSV/Excel)</a></li>
            <li><a href="{{ route('admin.approvals') }}" class="admin-link">Order Approvals</a></li>
            <li><a href="{{ route('admin.export') }}" class="admin-link">Export Orders (CSV/EDI)</a></li>
        </ul>
    </div>
    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
        <div class="admin-title mb-2 text-green-800 text-xl font-bold">Product & Catalog</div>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.products') }}" class="admin-link">Manage Products</a></li>
            <li><a href="{{ route('admin.stock') }}" class="admin-link">Stock & Lead Time</a></li>
            <li><a href="{{ route('admin.pricing') }}" class="admin-link">Pricing Tiers</a></li>
            <li><a href="{{ route('admin.documents') }}" class="admin-link">Documents & Datasheets</a></li>
            <li><a href="{{ route('admin.brands') }}" class="admin-link">Brands & Standards</a></li>
        </ul>
    </div>
    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center">
        <div class="admin-title mb-2 text-green-800 text-xl font-bold">Accounts & Settings</div>
        <ul class="space-y-2">
            <li><a href="{{ route('admin.user_management') }}" class="admin-link">User Management</a></li>
            <li><a href="{{ route('admin.business') }}" class="admin-link">Business Info & Tax Certs</a></li>
            <li><a href="{{ route('admin.audit') }}" class="admin-link">Audit Log</a></li>
            <li><a href="{{ route('admin.freight') }}" class="admin-link">Freight & Logistics</a></li>
            <li><a href="{{ route('admin.site_settings') }}" class="admin-link">Site Settings</a></li>
        </ul>
    </div>
</div>
@endsection
