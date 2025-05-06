@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="container mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Edit Payment</h2>
            <a href="{{ route('payments.show', $payment) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Payment
            </a>
        </div>
        
        <form action="{{ route('payments.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Invoice Selection -->
                    <div class="form-group">
                        <label for="invoice_id" class="form-label">Invoice</label>
                        <select name="invoice_id" id="invoice_id" class="form-select" required>
                            <option value="">Select Invoice</option>
                            @foreach($invoices as $invoice)
                                <option value="{{ $invoice->id }}" {{ $payment->invoice_id == $invoice->id ? 'selected' : '' }}>
                                    {{ $invoice->invoice_number }} - {{ $invoice->client->name }} (${{ number_format($invoice->total, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Client (Auto-filled) -->
                    <div class="form-group">
                        <label for="client_id" class="form-label">Client</label>
                        <select name="client_id" id="client_id" class="form-select" required disabled>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $payment->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="client_id" value="{{ $payment->client_id }}">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Payment Date -->
                    <div class="form-group">
                        <label for="payment_date" class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-input" value="{{ $payment->payment_date->format('Y-m-d') }}" required>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="bank_transfer" {{ $payment->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="credit_card" {{ $payment->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="paypal" {{ $payment->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="cheque" {{ $payment->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="other" {{ $payment->payment_method == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label">Amount</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" class="form-input pl-7" min="0.01" step="0.01" value="{{ $payment->amount }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction ID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="form-group">
                        <label for="transaction_id" class="form-label">Transaction ID</label>
                        <input type="text" name="transaction_id" id="transaction_id" class="form-input" value="{{ $payment->transaction_id }}">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional: Enter the transaction ID from your payment processor.</p>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="form-input">{{ $payment->notes }}</textarea>
                </div>
            </div>
            
            <div class="card-footer flex justify-between">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Payment</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceSelect = document.getElementById('invoice_id');
        const clientSelect = document.getElementById('client_id');
        const amountInput = document.getElementById('amount');
        
        // Map of invoice IDs to their details
        const invoiceData = {
            @foreach($invoices as $invoice)
                {{ $invoice->id }}: {
                    client_id: {{ $invoice->client_id }},
                    total: {{ $invoice->total }},
                    balance: {{ $invoice->balance }}
                },
            @endforeach
        };
        
        // Update client and amount when invoice changes
        invoiceSelect.addEventListener('change', function() {
            const invoiceId = this.value;
            if (invoiceId && invoiceData[invoiceId]) {
                // Update client
                clientSelect.value = invoiceData[invoiceId].client_id;
                document.querySelector('input[name="client_id"]').value = invoiceData[invoiceId].client_id;
                
                // Suggest remaining balance as amount
                amountInput.value = invoiceData[invoiceId].balance.toFixed(2);
            }
        });
    });
</script>
@endpush
