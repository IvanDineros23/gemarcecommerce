<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        // Get recent chat messages for this employee
        $chatMessages = \App\Models\ChatMessage::with('sender')->where('receiver_id', $u->id)->latest()->limit(10)->get();

        // Get recent cart activity (add to cart) for notification
        $cartActivities = \App\Models\CartItem::with(['product', 'cart' => function($q) { $q->with('user'); }])
            ->latest()->limit(10)->get();

        $notifications = collect();
        foreach ($cartActivities as $item) {
            if ($item->cart && $item->product && $item->cart->user) {
                $notifications->push((object) [
                    'type' => 'cart',
                    'user' => $item->cart->user->name,
                    'product' => $item->product->name,
                    'qty' => $item->qty,
                    'created_at' => $item->created_at,
                ]);
            }
        }

        // Merge chat messages and cart notifications, sort by date desc, limit 10
        $allNotifications = $chatMessages->map(function($msg) {
            return (object) [
                'type' => 'chat',
                'user' => $msg->sender ? $msg->sender->name : 'System',
                'message' => $msg->message,
                'created_at' => $msg->created_at,
            ];
        })->merge($notifications)->sortByDesc('created_at')->take(10);

    $data = [
            'recentOrders' => \App\Models\Order::where('user_id',$u->id)->latest()->limit(5)->get(),
            'kpis' => [
                'openOrders'  => \App\Models\Order::where('user_id',$u->id)
                                   ->whereIn('status',['pending','paid','processing'])->count(),
                'openQuotes'  => \App\Models\Quote::where('user_id',$u->id)->where('status','open')->count(),
                'inTransit'   => \App\Models\Shipment::where('user_id', $u->id)->where('status','in_transit')->count(),
                'invoicesDue' => \App\Models\Invoice::where('user_id',$u->id)->where('status','unpaid')->sum('balance_due'),
                'backorders'  => \App\Models\OrderItem::whereHas('order', fn($q)=>$q->where('user_id',$u->id))
                                   ->sum('backordered_qty'),
            ],
            'notifications' => $allNotifications,
            'openQuotes'   => \App\Models\Quote::where('user_id',$u->id)->where('status','open')
                                   ->orderBy('expires_at')->limit(5)->get(),
            'shipments'    => \App\Models\Shipment::where('user_id', $u->id)->latest()->limit(5)->get(),
            'savedLists'   => \App\Models\SavedList::where('user_id',$u->id)->latest()->limit(5)->get(),
            'activeCarts'  => \App\Models\Cart::where('user_id',$u->id)->whereNull('checked_out_at')
                                   ->latest()->limit(3)->get(),
            // Automated recommended products: 4 random active products
            'recommendedProducts' => \App\Models\Product::where('is_active', true)->inRandomOrder()->limit(4)->get(),
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
