@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto py-10" x-data="{}">
    <h1 class="text-2xl font-bold text-green-800 mb-6">Settings</h1>

    <!-- Basic Settings Dropdown -->
    <div x-data="{ open: true }" class="bg-white rounded-xl shadow mb-4">
        <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
            Basic Information
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="px-6 pb-6 pt-2">
            <form x-data="{ email: '', confirm: '', match: true }" @input="match = (email === confirm)">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" value="Ivan Dineros" readonly disabled>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Current Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" value="{{ Auth::user()->email }}" readonly disabled>
                </div>
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

    <!-- Payment Details Dropdown -->
    <div x-data="{ open: false }" class="bg-white rounded-xl shadow mb-4">
        <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
            Payment Details
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="px-6 pb-6 pt-2">
            <form x-data="{ method: 'card', ewallet: 'gcash' }">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Payment Method</label>
                    <select x-model="method" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="card">Card Payment</option>
                        <option value="ewallet">E-Wallet</option>
                        <option value="check">Check Payment</option>
                    </select>
                </div>
                <template x-if="method === 'card'">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Cardholder Name</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Juan Dela Cruz">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Card Number</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="flex gap-4 mb-4">
                            <div class="flex-1">
                                <label class="block text-gray-700 mb-1">Expiry</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="MM/YY">
                            </div>
                            <div class="flex-1">
                                <label class="block text-gray-700 mb-1">CVV</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="123">
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="method === 'ewallet'">
                    <div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">E-Wallet Type</label>
                            <select x-model="ewallet" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="gcash">GCash</option>
                                <option value="maya">Maya</option>
                                <option value="paypal">PayPal</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <template x-if="ewallet === 'gcash' || ewallet === 'maya'">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">Mobile Number</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="09xxxxxxxxx">
                            </div>
                        </template>
                        <template x-if="ewallet === 'paypal'">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">PayPal Email</label>
                                <input type="email" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="your@email.com">
                            </div>
                        </template>
                        <template x-if="ewallet === 'other'">
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-1">E-Wallet Details</label>
                                <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="E-Wallet Name/Number">
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="method === 'check'">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Check Payee Name</label>
                        <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Payee Name">
                    </div>
                </template>
                <button type="button" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 font-semibold">Save Payment Details</button>
            </form>
        </div>
    </div>

    <!-- Delivery Option Dropdown -->
    <div x-data="{ open: false }" class="bg-white rounded-xl shadow mb-4">
        <button @click="open = !open" class="w-full flex justify-between items-center px-6 py-4 text-lg font-semibold text-green-700 focus:outline-none">
            Delivery Option
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
        </button>
        <div x-show="open" class="px-6 pb-6 pt-2">
            <form x-data="{ method: 'standard' }">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Delivery Method</label>
                    <select x-model="method" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="standard">Standard Delivery</option>
                        <option value="express">Express Delivery</option>
                        <option value="pickup">Pickup</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <template x-if="method !== 'pickup'">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Delivery Address</label>
                        <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="123 Main St, City, Province">
                    </div>
                </template>
                <template x-if="method === 'other'">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Other Delivery Details</label>
                        <input type="text" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Describe delivery method">
                    </div>
                </template>
                <button type="button" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 font-semibold">Save Delivery Option</button>
            </form>
        </div>
    </div>
</div>
<!-- Alpine.js for dropdowns (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
