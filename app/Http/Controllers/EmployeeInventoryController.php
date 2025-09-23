<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class EmployeeInventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('dashboard.employee_inventory', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);
        $product->stock = $request->stock;
        $product->save();
        return redirect()->route('employee.inventory.index')->with('success', 'Stock updated!');
    }
}
