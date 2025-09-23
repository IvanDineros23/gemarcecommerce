<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        $data = [
            'kpis' => [
                'openOrders'  => \App\Models\Order::where('user_id',$u->id)
                                   ->whereIn('status',['pending','paid','processing'])->count(),
                'openQuotes'  => \App\Models\Quote::where('user_id',$u->id)->where('status','open')->count(),
                'inTransit'   => \App\Models\Shipment::where('user_id', $u->id)->where('status','in_transit')->count(),
                'invoicesDue' => \App\Models\Invoice::where('user_id',$u->id)->where('status','unpaid')->sum('balance_due'),
                'backorders'  => \App\Models\OrderItem::whereHas('order', fn($q)=>$q->where('user_id',$u->id))
                                   ->sum('backordered_qty'),
            ],
            'recentOrders' => \App\Models\Order::where('user_id',$u->id)->latest()->limit(5)->get(),
            'openQuotes'   => \App\Models\Quote::where('user_id',$u->id)->where('status','open')
                                   ->orderBy('expires_at')->limit(5)->get(),
            'shipments'    => \App\Models\Shipment::where('user_id', $u->id)->latest()->limit(5)->get(),
            'savedLists'   => \App\Models\SavedList::where('user_id',$u->id)->latest()->limit(5)->get(),
            'activeCarts'  => \App\Models\Cart::where('user_id',$u->id)->whereNull('checked_out_at')
                                   ->latest()->limit(3)->get(),
        ];

        if ($u->isUser()) {
            return view('dashboard.user', $data);
        } elseif ($u->isEmployee()) {
            return view('dashboard.employee', $data);
        } else {
            return view('dashboard.index', $data);
        }
    }
}
