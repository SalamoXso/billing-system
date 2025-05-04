@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">System Settings</h2>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-800 dark:text-green-100 dark:border-green-600" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Company Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" value="{{ $settings['company.name'] ?? 'Your Company Name' }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="company_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Address</label>
                                    <textarea name="company_address" id="company_address" rows="3"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $settings['company.address'] ?? '123 Business Street, City, State ZIP' }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="company_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Phone</label>
                                    <input type="text" name="company_phone" id="company_phone" value="{{ $settings['company.phone'] ?? '(123) 456-7890' }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="company_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Email</label>
                                    <input type="email" name="company_email" id="company_email" value="{{ $settings['company.email'] ?? 'info@company.com' }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Invoice Settings -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Invoice Settings</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="invoice_prefix" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Invoice Prefix</label>
                                    <input type="text" name="invoice_prefix" id="invoice_prefix" value="{{ $settings['invoice.prefix'] ?? 'INV-' }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="invoice_next_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Next Invoice Number</label>
                                    <input type="number" name="invoice_next_number" id="invoice_next_number" value="{{ $settings['invoice.next_number'] ?? '1001' }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                </div>
                                
                                <div>
                                    <label for="gst_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">GST Rate (%)</label>
                                    <input type="number" step="0.01" name="gst_rate" id="gst_rate" value="{{ ($settings['gst_rate'] ?? 0.10) * 100 }}"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter as a percentage (e.g., 10 for 10%)</p>
                                </div>
                                
                                <div>
                                    <label for="default_template" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Invoice Template</label>
                                    <select id="default_template" name="invoice_default_template" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="default" {{ ($settings['invoice.default_template'] ?? 'custom') == 'default' ? 'selected' : '' }}>Default</option>
                                        <option value="custom" {{ ($settings['invoice.default_template'] ?? 'custom') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Email Settings -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Email Settings</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">From Name</label>
                                <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['email.from.name'] ?? config('mail.from.name') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">From Email Address</label>
                                <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['email.from.address'] ?? config('mail.from.address') }}"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                            Note: SMTP settings (host, port, username, password, etc.) are configured in the .env file or server environment.
                        </p>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection