<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'checked_out_at' => null
        ]);
        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($item) => $item->unit_price * $item->qty);
        return view('cart.index', compact('cart', 'items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'checked_out_at' => null
        ]);
        $product = Product::findOrFail($request->product_id);
        $item = $cart->items()->firstOrNew(['product_id' => $request->product_id]);
        $item->qty = ($item->qty ?? 0) + ($request->quantity ?? 1);
        $item->unit_price = $product->price;
        $item->save();
        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'checked_out_at' => null
        ]);
        $quantities = $request->input('quantities', []);
        foreach ($quantities as $itemId => $qty) {
            $item = $cart->items()->find($itemId);
            if ($item && $qty > 0) {
                $item->qty = $qty;
                $item->save();
            }
        }
        return redirect()->route('cart.index');
    }
}
