@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="container mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Record Payment</h2>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Payments
            </a>
        </div>
        
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Invoice Selection -->
                    <div class="form-group">
                        <label for="invoice_id" class="form-label">Invoice</label>
                        <select name="invoice_id" id="invoice_id" class="form-select" required>
                            <option value="">Select Invoice</option>
                            @foreach($invoices as $invoice)
                                @if($invoice->balance > 0)
                                    <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                        {{ $invoice->invoice_number }} - {{ $invoice->client->name }} (${{ number_format($invoice->balance, 2) }} due)
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Client (Auto-filled) -->
                    <div class="form-group">
                        <label for="client_display" class="form-label">Client</label>
                        <input type="text" id="client_display" class="form-input bg-gray-100" readonly>
                        <input type="hidden" name="client_id" id="client_id">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Payment Date -->
                    <div class="form-group">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-input" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" class="form-input pl-7" min="0.01" step="0.01" value="{{ old('amount') }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction ID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label for="transaction_id" class="form-label">Transaction ID</label>
                        <input type="text" name="transaction_id" id="transaction_id" class="form-input" value="{{ old('transaction_id') }}">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional: Enter the transaction ID from your payment processor.</p>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="form-input">{{ old('notes') }}</textarea>
                </div>
                
                <!-- Invoice Details (will be populated via JS) -->
                <div id="invoice-details" class="mt-6 hidden">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Invoice Details</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Invoice Number:</p>
                            <p class="font-medium text-gray-900 dark:text-white" id="detail-invoice-number"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Invoice Date:</p>
                            <p class="font-medium text-gray-900 dark:text-white" id="detail-invoice-date"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Due Date:</p>
                            <p class="font-medium text-gray-900 dark:text-white" id="detail-due-date"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount:</p>
                            <p class="font-medium text-gray-900 dark:text-white" id="detail-total"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Amount Paid:</p>
                            <p class="font-medium text-gray-900 dark:text-white" id="detail-paid"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Balance Due:</p>
                            <p class="font-medium text-red-600 dark:text-red-400" id="detail-balance"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer flex justify-between">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Record Payment</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceSelect = document.getElementById('invoice_id');
        const clientDisplay = document.getElementById('client_display');
        const clientIdInput = document.getElementById('client_id');
        const amountInput = document.getElementById('amount');
        const invoiceDetails = document.getElementById('invoice-details');
        
        // Invoice data
        const invoiceData = {
            @foreach($invoices as $invoice)
                {{ $invoice->id }}: {
                    client_id: {{ $invoice->client_id }},
                    client_name: "{{ $invoice->client->name }}",
                    invoice_number: "{{ $invoice->invoice_number }}",
                    invoice_date: "{{ $invoice->invoice_date->format('d/m/Y') }}",
                    due_date: "{{ $invoice->due_date->format('d/m/Y') }}",
                    total: {{ $invoice->total }},
                    paid: {{ $invoice->payments->sum('amount') }},
                    balance: {{ $invoice->balance }}
                },
            @endforeach
        };
        
        // Update client and amount when invoice changes
        invoiceSelect.addEventListener('change', function() {
            const invoiceId = this.value;
            if (invoiceId && invoiceData[invoiceId]) {
                // Update client
                clientDisplay.value = invoiceData[invoiceId].client_name;
                clientIdInput.value = invoiceData[invoiceId].client_id;
                
                // Suggest remaining balance as amount
                amountInput.value = invoiceData[invoiceId].balance.toFixed(2);
                
                // Show invoice details
                document.getElementById('detail-invoice-number').textContent = invoiceData[invoiceId].invoice_number;
                document.getElementById('detail-invoice-date').textContent = invoiceData[invoiceId].invoice_date;
                document.getElementById('detail-due-date').textContent = invoiceData[invoiceId].due_date;
                document.getElementById('detail-total').textContent = '$' + invoiceData[invoiceId].total.toFixed(2);
                document.getElementById('detail-paid').textContent = '$' + invoiceData[invoiceId].paid.toFixed(2);
                document.getElementById('detail-balance').textContent = '$' + invoiceData[invoiceId].balance.toFixed(2);
                
                invoiceDetails.classList.remove('hidden');
            } else {
                clientDisplay.value = '';
                clientIdInput.value = '';
                amountInput.value = '';
                invoiceDetails.classList.add('hidden');
            }
        });
        
        // Initialize if there's a selected invoice
        if (invoiceSelect.value) {
            invoiceSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
