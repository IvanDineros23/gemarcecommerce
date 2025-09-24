<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function savePaymentDetails(Request $request)
    {
        $request->validate([
            'method' => 'required|string|max:32',
            'card_name' => 'nullable|string|max:100',
            'card_number' => 'nullable|string|max:32',
            'expiry' => 'nullable|string|max:10',
            'cvv' => 'nullable|string|max:10',
            'ewallet' => 'nullable|string|max:32',
            'mobile' => 'nullable|string|max:32',
            'paypal_email' => 'nullable|email|max:100',
            'ewallet_details' => 'nullable|string|max:100',
            'check_payee' => 'nullable|string|max:100',
        ]);
        $user = Auth::user();
        $data = [ 'method' => $request->method ];
        if ($request->method === 'card') {
            $data['card_name'] = $request->card_name;
            $data['card_number'] = $request->card_number;
            $data['expiry'] = $request->expiry;
            $data['cvv'] = $request->cvv;
        } elseif ($request->method === 'ewallet') {
            $data['ewallet'] = $request->ewallet;
            if ($request->ewallet === 'gcash' || $request->ewallet === 'maya') {
                $data['mobile'] = $request->mobile;
            } elseif ($request->ewallet === 'paypal') {
                $data['paypal_email'] = $request->paypal_email;
            } else {
                $data['ewallet_details'] = $request->ewallet_details;
            }
        } elseif ($request->method === 'check') {
            $data['check_payee'] = $request->check_payee;
        }
        $user->payment_details = $data;
        $user->save();
        return redirect()->route('settings')->with('success', 'Payment details saved!');
    }
    public function saveDeliveryAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'category' => 'required|string|max:32',
            'other_category' => 'nullable|string|max:32',
        ]);
        $user = Auth::user();
        $category = $request->category === 'other' && $request->filled('other_category')
            ? $request->other_category : $request->category;
        $user->delivery_option = [
            'address' => $request->address,
            'category' => $category,
        ];
        $user->save();
        return redirect()->route('settings')->with('success', 'Delivery address saved!');
    }
}