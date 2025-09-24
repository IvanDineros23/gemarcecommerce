<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\{ChatMessage, CartItem, Order, Quote, Shipment, Invoice, OrderItem, SavedList, Cart, Product};

class DashboardController extends Controller
{
    public function index()
    {
        $u = auth()->user();

        // Messages (limit columns for speed)
        $chatMessages = ChatMessage::with('sender:id,name')
            ->where('receiver_id', $u->id)
            ->latest()->limit(10)->get();

        // Cart activity (with user + product names)
        $cartActivities = CartItem::with([
                'product:id,name',
                'cart.user:id,name'
            ])->latest()->limit(10)->get();

        // Build cart notifications as arrays
        $notifications = collect();
        foreach ($cartActivities as $item) {
            if ($item->cart && $item->product && $item->cart->user) {
                $notifications->push([
                    'type'       => 'cart',
                    'user'       => $item->cart->user->name,
                    'product'    => $item->product->name,
                    'qty'        => $item->qty,
                    'created_at' => Carbon::parse($item->created_at),
                ]);
            }
        }

        // Map chat messages to arrays
        $chatNotifs = $chatMessages->map(function ($msg) {
            return [
                'type'       => 'chat',
                'user'       => optional($msg->sender)->name ?? 'System',
                'message'    => $msg->message,
                'created_at' => $msg->created_at instanceof Carbon
                                ? $msg->created_at
                                : Carbon::parse($msg->created_at),
            ];
        });

        // ✅ Force Support\Collection all the way; no Eloquent methods involved
        $allNotifications = collect()
            ->concat($chatNotifs->values())
            ->concat($notifications->values())
            ->sortByDesc('created_at')
            ->take(10)
            ->values(); // <-- keep as Collection (no ->all())

        $data = [
            'recentOrders' => Order::where('user_id', $u->id)->latest()->limit(5)->get(),
            'kpis' => [
                'openOrders'  => Order::where('user_id',$u->id)
                                      ->whereIn('status',['pending','paid','processing'])->count(),
                'openQuotes'  => Quote::where('user_id',$u->id)->where('status','open')->count(),
                'inTransit'   => Shipment::where('user_id',$u->id)->where('status','in_transit')->count(),
                'invoicesDue' => Invoice::where('user_id',$u->id)->where('status','unpaid')->sum('balance_due'),
                'backorders'  => OrderItem::whereHas('order', fn($q)=>$q->where('user_id',$u->id))
                                          ->sum('backordered_qty'),
            ],
            'notifications' => $allNotifications, // still a Collection
            'openQuotes'    => Quote::where('user_id',$u->id)->where('status','open')
                                    ->orderBy('expires_at')->limit(5)->get(),
            'shipments'     => Shipment::where('user_id', $u->id)->latest()->limit(5)->get(),
            'savedLists'    => SavedList::where('user_id',$u->id)->latest()->limit(5)->get(),
            'activeCarts'   => Cart::where('user_id',$u->id)->whereNull('checked_out_at')
                                    ->latest()->limit(3)->get(),
            'recommendedProducts' => Product::where('is_active', true)->inRandomOrder()->limit(4)->get(),
        ];

        if ($u->isUser())      return view('dashboard.user', $data);
        elseif ($u->isEmployee()) return view('dashboard.employee', $data);
        else                    return view('dashboard.index', $data);
    }
}
