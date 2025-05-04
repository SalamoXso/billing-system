@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Settings</h3>
                </div>
                <div class="card-body p-0">
                    <nav class="space-y-1">
                        <a href="#company-settings" class="flex items-center px-4 py-3 text-sm font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/50 dark:text-blue-300 border-l-4 border-blue-600 dark:border-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Company Information
                        </a>
                        <a href="#invoice-settings" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Invoice Settings
                        </a>
                        <a href="#tax-settings" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Tax Settings
                        </a>
                        <a href="#email-settings" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email Settings
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Settings Content -->
        <div class="lg:col-span-2">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                
                <!-- Company Information -->
                <div id="company-settings" class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Company Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="form-group">
                                <label for="company.name" class="form-label">Company Name</label>
                                <input type="text" name="company.name" id="company.name" value="{{ $settings['company.name'] ?? '' }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="company.address" class="form-label">Address</label>
                                <textarea name="company.address" id="company.address" rows="3" class="form-input">{{ $settings['company.address'] ?? '' }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="company.phone" class="form-label">Phone</label>
                                    <input type="text" name="company.phone" id="company.phone" value="{{ $settings['company.phone'] ?? '' }}" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="company.email" class="form-label">Email</label>
                                    <input type="email" name="company.email" id="company.email" value="{{ $settings['company.email'] ?? '' }}" class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="company.website" class="form-label">Website</label>
                                <input type="url" name="company.website" id="company.website" value="{{ $settings['company.website'] ?? '' }}" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Invoice Settings -->
                <div id="invoice-settings" class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Invoice Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="invoice.prefix" class="form-label">Invoice Prefix</label>
                                    <input type="text" name="invoice.prefix" id="invoice.prefix" value="{{ $settings['invoice.prefix'] ?? 'INV-' }}" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="invoice.next_number" class="form-label">Next Invoice Number</label>
                                    <input type="number" name="invoice.next_number" id="invoice.next_number" value="{{ $settings['invoice.next_number'] ?? '1001' }}" class="form-input">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="invoice.default_template" class="form-label">Default Template</label>
                                <select name="invoice.default_template" id="invoice.default_template" class="form-select">
                                    <option value="custom" {{ ($settings['invoice.default_template'] ?? 'custom') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    <option value="simple" {{ ($settings['invoice.default_template'] ?? '') == 'simple' ? 'selected' : '' }}>Simple</option>
                                    <option value="professional" {{ ($settings['invoice.default_template'] ?? '') == 'professional' ? 'selected' : '' }}>Professional</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="invoice.default_due_days" class="form-label">Default Due Days</label>
                                <input type="number" name="invoice.default_due_days" id="invoice.default_due_days" value="{{ $settings['invoice.default_due_days'] ?? '30' }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="invoice.notes" class="form-label">Default Invoice Notes</label>
                                <textarea name="invoice.notes" id="invoice.notes" rows="3" class="form-input">{{ $settings['invoice.notes'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tax Settings -->
                <div id="tax-settings" class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Tax Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="form-group">
                                <label for="gst_rate" class="form-label">GST Rate (%)</label>
                                <input type="number" name="gst_rate" id="gst_rate" value="{{ ($settings['gst_rate'] ?? '0.10') * 100 }}" step="0.01" min="0" max="100" class="form-input">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the GST rate as a percentage (e.g., 10 for 10%).</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="tax_number" class="form-label">Tax Registration Number</label>
                                <input type="text" name="tax_number" id="tax_number" value="{{ $settings['tax_number'] ?? '' }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <div class="flex items-center">
                                    <input type="checkbox" name="tax_included_in_prices" id="tax_included_in_prices" class="form-checkbox" {{ ($settings['tax_included_in_prices'] ?? false) ? 'checked' : '' }}>
                                    <label for="tax_included_in_prices" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Prices include tax
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">If checked, all prices entered will be considered to include tax.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Email Settings -->
                <div id="email-settings" class="card mb-6">
                    <div class="card-header">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Email Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="form-group">
                                <label for="email.from_address" class="form-label">From Email Address</label>
                                <input type="email" name="email.from_address" id="email.from_address" value="{{ $settings['email.from_address'] ?? '' }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="email.from_name" class="form-label">From Name</label>
                                <input type="text" name="email.from_name" id="email.from_name" value="{{ $settings['email.from_name'] ?? '' }}" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label for="email.invoice_subject" class="form-label">Invoice Email Subject</label>
                                <input type="text" name="email.invoice_subject" id="email.invoice_subject" value="{{ $settings['email.invoice_subject'] ?? 'Invoice [Invoice Number] from [Company Name]' }}" class="form-input">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You can use placeholders: [Invoice Number], [Company Name], [Client Name], [Due Date]</p>
                            </div>
                            
                            <div class="form-group">
                                <label for="email.invoice_template" class="form-label">Invoice Email Template</label>
                                <textarea name="email.invoice_template" id="email.invoice_template" rows="5" class="form-input">{{ $settings['email.invoice_template'] ?? "Dear [Client Name],\n\nPlease find attached invoice [Invoice Number] for your recent services.\n\nThe invoice is due on [Due Date].\n\nThank you for your business.\n\nRegards,\n[Company Name]" }}</textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You can use placeholders: [Invoice Number], [Company Name], [Client Name], [Due Date], [Amount], [Payment Link]</p>
                            </div>
                            
                            <div class="form-group">
                                <div class="flex items-center">
                                    <input type="checkbox" name="email.send_payment_receipt" id="email.send_payment_receipt" class="form-checkbox" {{ ($settings['email.send_payment_receipt'] ?? true) ? 'checked' : '' }}>
                                    <label for="email.send_payment_receipt" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Send payment receipt emails
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="flex items-center">
                                    <input type="checkbox" name="email.send_payment_reminders" id="email.send_payment_reminders" class="form-checkbox" {{ ($settings['email.send_payment_reminders'] ?? false) ? 'checked' : '' }}>
                                    <label for="email.send_payment_reminders" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Send payment reminder emails
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
