<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-white flex flex-col py-8 px-4 min-h-screen">
            <div class="mb-8 text-2xl font-bold tracking-wide text-center">Admin Panel</div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-gray-800 font-semibold">Dashboard</a></li>
                    <li><a href="{{ route('admin.orders') }}" class="block py-2 px-3 rounded hover:bg-gray-800">All Orders</a></li>
                    <li><a href="{{ route('admin.quotes') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Quotes Management</a></li>
                    <li><a href="{{ route('admin.uploads') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Bulk Uploads</a></li>
                    <li><a href="{{ route('admin.approvals') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Order Approvals</a></li>
                    <li><a href="{{ route('admin.export') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Export Orders</a></li>
                    <li><a href="{{ route('admin.products') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Manage Products</a></li>
                    <li><a href="{{ route('admin.stock') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Stock & Lead Time</a></li>
                    <li><a href="{{ route('admin.pricing') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Pricing Tiers</a></li>
                    <li><a href="{{ route('admin.documents') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Documents</a></li>
                    <li><a href="{{ route('admin.brands') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Brands & Standards</a></li>
                    <li><a href="{{ route('admin.user_management') }}" class="block py-2 px-3 rounded hover:bg-gray-800">User Management</a></li>
                    <li><a href="{{ route('admin.business') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Business Info</a></li>
                    <li><a href="{{ route('admin.audit') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Audit Log</a></li>
                    <li><a href="{{ route('admin.freight') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Freight & Logistics</a></li>
                    <li><a href="{{ route('admin.site_settings') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Site Settings</a></li>
                    <li><a href="{{ route('admin.settings') }}" class="block py-2 px-3 rounded hover:bg-gray-800">Settings</a></li>
                    <li><a href="{{ route('logout') }}" class="block py-2 px-3 rounded hover:bg-red-700 text-red-300"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </nav>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </aside>
        {{-- Main Content --}}
        <main class="flex-1 bg-gray-100 p-10">
            @yield('content')
        </main>
    </div>
</body>
</html>
