<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Quote;

class QuoteController extends Controller
{
    // Show create quote form
    public function create(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('is_active', 1)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%")
                      ->orWhere('sku', 'like', "%$search%")
                      ->orWhere('id', $search);
                });
            })
            ->with('images')
            ->get();
        return view('quotes.create', compact('products', 'search'));
    }

    // Store quote and generate PDF (stub)
    public function store(Request $request)
    {
        // Validate and save quote logic here
        // Generate PDF logic here
        return back()->with('success', 'Quote created and PDF generated (stub).');
    }

    // Download/preview PDF (stub)
    public function pdf($quoteId)
    {
        // Fetch quote and generate PDF logic here
        return 'PDF generation for quote #' . $quoteId;
    }

    // Employee: list all quotes (stub)
    public function employeeIndex()
    {
        // Fetch all quotes for employees
        return view('placeholders.employee_quotes');
    }

    // Employee: show a specific quote (stub)
    public function employeeShow($quoteId)
    {
        // Fetch and show quote details
        return 'Show quote #' . $quoteId . ' for employee (stub)';
    }
}
