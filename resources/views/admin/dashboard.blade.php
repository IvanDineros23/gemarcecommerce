{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Gemarc Enterprises Inc</title>
    <link rel="icon" type="image/png" href="{{ asset('images/gemarclogo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome-industrial.css') }}">
    <style>
        body { background: #181b1f; color: #222; }
        .admin-header { background: #23262b; color: #fff; padding: 1.5rem 2rem; border-radius: 1rem; margin-bottom: 2rem; }
        .admin-section { background: #fff; border-radius: 1rem; box-shadow: 0 4px 16px 0 rgba(0,0,0,0.10); padding: 2rem; margin-bottom: 2rem; }
        .admin-title { color: #2e7d32; font-weight: 700; }
        .admin-accent { color: #f97316; font-weight: 600; }
        .admin-badge { background: #2e7d32; color: #fff; font-size: 0.9rem; border-radius: 0.5rem; padding: 0.2rem 0.7rem; margin-left: 0.5rem; }
        .admin-link { color: #f97316; text-decoration: none; }
        .admin-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="admin-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/gemarclogo.png') }}" alt="Gemarc Logo" height="48">
                <span class="fs-4 fw-bold">GEMARC Admin Panel</span>
                <span class="admin-badge">ISO 9001</span>
                <span class="admin-badge">UL Listed</span>
            </div>
            <div>
                <a href="#" class="admin-link me-3">Settings</a>
                <a href="#" class="admin-link">Logout</a>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="admin-section">
                    <div class="admin-title mb-2">Orders & Quotes</div>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="admin-link">All Orders</a></li>
                        <li><a href="#" class="admin-link">Quotes Management</a></li>
                        <li><a href="#" class="admin-link">Bulk Uploads (CSV/Excel)</a></li>
                        <li><a href="#" class="admin-link">Order Approvals</a></li>
                        <li><a href="#" class="admin-link">Export Orders (CSV/EDI)</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-section">
                    <div class="admin-title mb-2">Product & Catalog</div>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="admin-link">Manage Products</a></li>
                        <li><a href="#" class="admin-link">Stock & Lead Time</a></li>
                        <li><a href="#" class="admin-link">Pricing Tiers</a></li>
                        <li><a href="#" class="admin-link">Documents & Datasheets</a></li>
                        <li><a href="#" class="admin-link">Brands & Standards</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-section">
                    <div class="admin-title mb-2">Accounts & Settings</div>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#" class="admin-link">Users & Roles</a></li>
                        <li><a href="#" class="admin-link">Business Info & Tax Certs</a></li>
                        <li><a href="#" class="admin-link">Audit Log</a></li>
                        <li><a href="#" class="admin-link">Freight & Logistics</a></li>
                        <li><a href="#" class="admin-link">Site Settings</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center text-muted small mt-4">&copy; {{ date('Y') }} Gemarc Enterprises Inc. Admin Panel. All rights reserved.</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
