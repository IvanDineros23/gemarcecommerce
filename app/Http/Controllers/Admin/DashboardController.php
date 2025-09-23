<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalOrders' => Order::count(),
            'totalUsers' => User::count(),
            'totalSales' => Invoice::where('status', 'paid')->sum('total_amount'),
        ]);
    }
}
