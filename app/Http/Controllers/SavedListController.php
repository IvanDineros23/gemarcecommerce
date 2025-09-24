<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedList;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SavedListController extends Controller
{
    public function index()
    {
        // Get all saved lists for the user
        $savedLists = SavedList::where('user_id', Auth::id())->get();
        // Get all saved items for these lists, eager load product
        $savedItems = \App\Models\SavedListItem::whereIn('saved_list_id', $savedLists->pluck('id'))
            ->with('product')
            ->get();
        return view('saved.index', compact('savedItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $user = Auth::user();
        // Find or create a default saved list for the user
        $savedList = SavedList::where('user_id', $user->id)->where('name', 'Default')->first();
        if (!$savedList) {
            $savedList = SavedList::create([
                'user_id' => $user->id,
                'name' => 'Default',
                'description' => 'Default saved products list',
            ]);
        }
        $exists = \App\Models\SavedListItem::where('saved_list_id', $savedList->id)
            ->where('product_id', $request->product_id)
            ->exists();
        if (!$exists) {
            \App\Models\SavedListItem::create([
                'saved_list_id' => $savedList->id,
                'product_id' => $request->product_id,
            ]);
        }
        return redirect()->route('saved.index')->with('success', 'Product saved!');
    }

    public function destroy($id)
    {
    // Only allow deleting items from the user's own saved lists
    $user = Auth::user();
    $savedListIds = SavedList::where('user_id', $user->id)->pluck('id');
    $item = \App\Models\SavedListItem::whereIn('saved_list_id', $savedListIds)->where('id', $id)->firstOrFail();
    $item->delete();
    return back()->with('success', 'Removed from saved items.');
    }
}
