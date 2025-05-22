@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Settings</h1>
        <button type="submit" form="settings-form" class="btn btn-primary">
            Save Changes
        </button>
    </div>

    <div class="dashboard-card">
        <form id="settings-form" class="space-y-6">
            <div>
                <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">Company Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-input" value="Your Company Name">
                    </div>
                    <div class="form-group">
                        <label for="company_email" class="form-label">Email Address</label>
                        <input type="email" id="company_email" name="company_email" class="form-input" value="contact@example.com">
                    </div>
                    <div class="form-group">
                        <label for="company_phone" class="form-label">Phone Number</label>
                        <input type="text" id="company_phone" name="company_phone" class="form-input" value="+1 (555) 123-4567">
                    </div>
                    <div class="form-group">
                        <label for="company_website" class="form-label">Website</label>
                        <input type="url" id="company_website" name="company_website" class="form-input" value="https://example.com">
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="company_address" class="form-label">Address</label>
                        <textarea id="company_address" name="company_address" rows="3" class="form-input">123 Business Street
City, State 12345
United States</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">Invoice Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="invoice_prefix" class="form-label">Invoice Prefix</label>
                        <input type="text" id="invoice_prefix" name="invoice_prefix" class="form-input" value="INV-">
                    </div>
                    <div class="form-group">
                        <label for="quote_prefix" class="form-label">Quote Prefix</label>
                        <input type="text" id="quote_prefix" name="quote_prefix" class="form-input" value="QUO-">
                    </div>
                    <div class="form-group">
                        <label for="payment_terms" class="form-label">Default Payment Terms (days)</label>
                        <input type="number" id="payment_terms" name="payment_terms" class="form-input" value="30">
                    </div>
                    <div class="form-group">
                        <label for="tax_rate" class="form-label">Default Tax Rate (%)</label>
                        <input type="number" id="tax_rate" name="tax_rate" step="0.01" class="form-input" value="7.5">
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="invoice_notes" class="form-label">Default Invoice Notes</label>
                        <textarea id="invoice_notes" name="invoice_notes" rows="3" class="form-input">Thank you for your business. Please make payment within the specified terms.</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">Email Notifications</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" id="notify_invoice" name="notify_invoice" class="form-checkbox" checked>
                        <label for="notify_invoice" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send email when invoice is created</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="notify_payment" name="notify_payment" class="form-checkbox" checked>
                        <label for="notify_payment" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send email when payment is received</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="notify_reminder" name="notify_reminder" class="form-checkbox" checked>
                        <label for="notify_reminder" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send payment reminders for overdue invoices</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
