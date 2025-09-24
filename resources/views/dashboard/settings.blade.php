@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-10" x-data="{}">
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
            <span class="font-semibold">{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif
    <h1 class="text-2xl font-bold text-green-800 mb-6">Settings</h1>

    <!-- Basic Settings Dropdown -->
    @php $isEmployee = Auth::user()->isEmployee(); $isUser = Auth::user()->isUser(); @endphp
    <div x-data="{ open: true }" class="bg-white rounded-xl shadow mb-4">
        <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
            Basic Information
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="px-6 pb-6 pt-2">
            <form x-data="{ email: '', confirm: '', match: true }" @input="match = (email === confirm)">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" value="{{ Auth::user()->name }}" readonly disabled>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Current Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" value="{{ Auth::user()->email }}" readonly disabled>
                </div>
                @if(!$isEmployee)
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">New Email</label>
                        <input type="email" x-model="email" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Enter new email">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Confirm New Email</label>
                        <input type="email" x-model="confirm" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Confirm new email">
                        <template x-if="confirm.length > 0">
                            <div class="text-xs mt-1" :class="match ? 'text-green-600' : 'text-red-500'">
                                <span x-show="match">✔ Emails match</span>
                                <span x-show="!match">✖ Emails do not match</span>
                            </div>
                        </template>
                    </div>
                    <button type="button" :disabled="!match || !email || !confirm" :class="['px-4 py-2 rounded font-semibold mb-4 transition', match && email && confirm ? 'bg-green-700 text-white hover:bg-green-800' : 'bg-gray-300 text-gray-500 cursor-not-allowed']">Save Basic Info</button>
                @endif
            </form>
        </div>
    </div>

    <!-- Change Password Dropdown -->
    <div x-data="{ open: false }" class="bg-white rounded-xl shadow mb-4">
        <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
            Change Password
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="px-6 pb-6 pt-2">
            <form x-data="{ password: '', strength: 0, strengthText: '', strengthColor: 'bg-gray-300' }" @input="
                strength = 0;
                strengthText = 'Weak';
                strengthColor = 'bg-red-400';
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                if (strength === 1) { strengthText = 'Weak'; strengthColor = 'bg-red-400'; }
                if (strength === 2) { strengthText = 'Fair'; strengthColor = 'bg-yellow-400'; }
                if (strength === 3) { strengthText = 'Good'; strengthColor = 'bg-blue-400'; }
                if (strength === 4) { strengthText = 'Strong'; strengthColor = 'bg-green-500'; }
            ">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Current Password</label>
                    <input type="password" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Current Password">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">New Password</label>
                    <input type="password" x-model="password" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="New Password">
                    <div class="h-2 mt-2 rounded transition-all" :class="strengthColor" :style="'width:' + (strength*25) + '%'" ></div>
                    <div class="text-xs mt-1" :class="strengthColor">Password strength: <span x-text="strengthText"></span></div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Confirm New Password">
                </div>
                <button type="button" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Change Password</button>
            </form>
        </div>
    </div>

    @if(!$isEmployee)
        <!-- Payment Details Dropdown -->
        <div x-data="{ open: false, method: '{{ old('method', Auth::user()->payment_details['method'] ?? 'card') }}', ewallet: '{{ old('ewallet', Auth::user()->payment_details['ewallet'] ?? 'gcash') }}' }" class="bg-white rounded-xl shadow mb-4">
            <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
                Payment Details
                <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" class="px-6 pb-6 pt-2">
                <form method="POST" action="{{ route('settings.savePaymentDetails') }}" x-data="{ method: '{{ old('method', Auth::user()->payment_details['method'] ?? 'card') }}', ewallet: '{{ old('ewallet', Auth::user()->payment_details['ewallet'] ?? 'gcash') }}' }">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Payment Method</label>
                        <select name="method" x-model="method" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="card">Card Payment</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="check">Check Payment</option>
                        </select>
                    </div>
                    <template x-if="method === 'card'">
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Cardholder Name</label>
                                <input type="text" name="card_name" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Juan Dela Cruz" value="{{ old('card_name', Auth::user()->payment_details['card_name'] ?? '') }}">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Card Number</label>
                                <input type="text" name="card_number" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="1234 5678 9012 3456" value="{{ old('card_number', Auth::user()->payment_details['card_number'] ?? '') }}">
                            </div>
                            <div class="flex gap-4 mb-4">
                                <div class="flex-1">
                                    <label class="block text-gray-700 mb-1">Expiry</label>
                                    <input type="text" name="expiry" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="MM/YY" value="{{ old('expiry', Auth::user()->payment_details['expiry'] ?? '') }}">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-gray-700 mb-1">CVV</label>
                                    <input type="text" name="cvv" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="123" value="{{ old('cvv', Auth::user()->payment_details['cvv'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="method === 'ewallet'">
                        <div>
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">E-Wallet Type</label>
                                <select name="ewallet" x-model="ewallet" class="w-full border border-gray-300 rounded px-3 py-2">
                                    <option value="gcash">GCash</option>
                                    <option value="maya">Maya</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <template x-if="ewallet === 'gcash' || ewallet === 'maya'">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-1">Mobile Number</label>
                                    <input type="text" name="mobile" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="09xxxxxxxxx" value="{{ old('mobile', Auth::user()->payment_details['mobile'] ?? '') }}">
                                </div>
                            </template>
                            <template x-if="ewallet === 'paypal'">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-1">PayPal Email</label>
                                    <input type="email" name="paypal_email" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="your@email.com" value="{{ old('paypal_email', Auth::user()->payment_details['paypal_email'] ?? '') }}">
                                </div>
                            </template>
                            <template x-if="ewallet === 'other'">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-1">E-Wallet Details</label>
                                    <input type="text" name="ewallet_details" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="E-Wallet Name/Number" value="{{ old('ewallet_details', Auth::user()->payment_details['ewallet_details'] ?? '') }}">
                                </div>
                            </template>
                        </div>
                    </template>
                    <template x-if="method === 'check'">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Check Payee Name</label>
                            <input type="text" name="check_payee" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Payee Name" value="{{ old('check_payee', Auth::user()->payment_details['check_payee'] ?? '') }}">
                        </div>
                    </template>
                    <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Save Payment Details</button>
                </form>
            </div>
        </div>
    @endif

    @if(!$isEmployee)
        <!-- Delivery Address Dropdown -->
        <div x-data="{ open: false, category: '{{ old('category', Auth::user()->delivery_option['category'] ?? 'home') }}' }" class="bg-white rounded-xl shadow mb-4">
            <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
                Delivery Address
                <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="open" class="px-6 pb-6 pt-2">
                <form method="POST" action="{{ route('settings.saveDeliveryAddress') }}" x-data="{ category: '{{ old('category', Auth::user()->delivery_option['category'] ?? 'home') }}' }">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Address</label>
                        <input type="text" name="address" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="123 Main St, City, Province" value="{{ old('address', Auth::user()->delivery_option['address'] ?? '') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Category</label>
                        <select name="category" x-model="category" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="home">Home</option>
                            <option value="office">Office</option>
                            <option value="school">School</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <template x-if="category === 'other'">
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Other Category</label>
                            <input type="text" name="other_category" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Specify category" value="{{ old('other_category') }}">
                        </div>
                    </template>
                    <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Save Delivery Address</button>
                </form>
            </div>
        </div>
    @endif
</div>
<!-- Alpine.js for dropdowns (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
