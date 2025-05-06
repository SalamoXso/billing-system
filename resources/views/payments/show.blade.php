@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Payment Details</h2>
            <div class="flex space-x-2">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Payments
                </a>
                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Payment
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Payment Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Payment Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Amount:</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Payment Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $payment->payment_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                @if($payment->payment_method == 'bank_transfer')
                                    Bank Transfer
                                @elseif($payment->payment_method == 'credit_card')
                                    Credit Card
                                @elseif($payment->payment_method == 'paypal')
                                    PayPal
                                @elseif($payment->payment_method == 'cash')
                                    Cash
                                @elseif($payment->payment_method == 'cheque')
                                    Cheque
                                @else
                                    {{ ucfirst($payment->payment_method) }}
                                @endif
                            </span>
                        </div>
                        @if($payment->transaction_id)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $payment->transaction_id }}</span>
                        </div>
                        @endif
                    </div>
                    
                    @if($payment->notes)
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-2">Notes</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-600 dark:text-gray-400">{{ $payment->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Invoice Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Invoice Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Invoice Number:</span>
                            <a href="{{ route('invoices.show', $payment->invoice) }}" class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $payment->invoice->invoice_number }}
                            </a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Invoice Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $payment->invoice->invoice_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Invoice Total:</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->invoice->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Amount Paid:</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($payment->invoice->payments->sum('amount'), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Balance Due:</span>
                            <span class="font-medium {{ $payment->invoice->balance > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                ${{ number_format($payment->invoice->balance, 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="font-medium">
                                <span class="badge {{ $payment->invoice->status == 'paid' ? 'badge-success' : ($payment->invoice->status == 'overdue' ? 'badge-danger' : 'badge-info') }}">
                                    {{ ucfirst($payment->invoice->status) }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Client Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Client Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Client Name:</span>
                            <a href="{{ route('clients.show', $payment->client) }}" class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $payment->client->name }}
                            </a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $payment->client->email }}</span>
                        </div>
                        @if($payment->client->phone)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $payment->client->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Payment History -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Payment History</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        @if($payment->invoice->payments->count() > 1)
                            <div class="space-y-3">
                                @foreach($payment->invoice->payments as $invoicePayment)
                                    <div class="flex justify-between items-center {{ $invoicePayment->id == $payment->id ? 'bg-blue-50 dark:bg-blue-900/20 p-2 rounded' : '' }}">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $invoicePayment->payment_date->format('d/m/Y') }}</span>
                                            @if($invoicePayment->id == $payment->id)
                                                <span class="ml-2 text-xs text-blue-600 dark:text-blue-400">(Current)</span>
                                            @endif
                                        </div>
                                        <span class="font-medium text-gray-900 dark:text-white">${{ number_format($invoicePayment->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">This is the only payment for this invoice.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer flex justify-between">
            <div>
                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Payment
                    </button>
                </form>
            </div>
            <div>
                <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-primary" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Receipt
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
