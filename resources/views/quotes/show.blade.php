@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Quote #{{ $quote->quote_number }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('quotes.index') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Quotes
                </a>
                <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Quote
                </a>
                <a href="{{ route('quotes.pdf', $quote) }}" class="btn btn-secondary" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    View PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Quote Status -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                    <span class="ml-2 badge 
                        @if($quote->status == 'draft') badge-gray
                        @elseif($quote->status == 'sent') badge-info
                        @elseif($quote->status == 'approved') badge-success
                        @elseif($quote->status == 'rejected') badge-danger
                        @elseif($quote->status == 'canceled') badge-warning
                        @endif">
                        {{ ucfirst($quote->status) }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    @if($quote->status == 'draft')
                        <form action="{{ route('quotes.send', $quote) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Send to Client
                            </button>
                        </form>
                    @endif

                    @if($quote->status == 'sent' || $quote->status == 'approved')
                        <form action="{{ route('quotes.convert', $quote) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Convert to Invoice
                            </button>
                        </form>
                    @endif

                    @if($quote->status != 'canceled')
                        <form action="{{ route('quotes.cancel', $quote) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this quote?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Quote
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Quote Header -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Company Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">From</h3>
                    <div class="text-gray-600 dark:text-gray-400">
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $settings['company.name'] ?? config('app.name') }}</p>
                        <p>{{ $settings['company.address'] ?? '' }}</p>
                        <p>{{ $settings['company.phone'] ?? '' }}</p>
                        <p>{{ $settings['company.email'] ?? '' }}</p>
                    </div>
                </div>

                <!-- Client Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">To</h3>
                    <div class="text-gray-600 dark:text-gray-400">
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $quote->client->name }}</p>
                        <p>{{ $quote->client->address }}</p>
                        <p>{{ $quote->client->phone }}</p>
                        <p>{{ $quote->client->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Quote Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Quote Number</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $quote->quote_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Quote Date</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $quote->quote_date->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Expiry Date</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $quote->expiry_date->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Quote Items -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Quote Items</h3>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-header">
                            <tr>
                                <th class="table-header-cell">Item</th>
                                <th class="table-header-cell">Description</th>
                                <th class="table-header-cell text-right">Quantity</th>
                                <th class="table-header-cell text-right">Unit Price</th>
                                <th class="table-header-cell text-right">Tax</th>
                                <th class="table-header-cell text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @foreach($quote->items as $item)
                                <tr class="table-row">
                                    <td class="table-cell font-medium text-gray-900 dark:text-white">
                                        {{ $item->product ? $item->product->name : 'Custom Item' }}
                                    </td>
                                    <td class="table-cell">
                                        {{ $item->description }}
                                    </td>
                                        @if($item->serialNumbers->count())
                                            <div class="serial-numbers">
                                                <strong>Serial Numbers:</strong>
                                                {{ $item->serialNumbers->pluck('serial_number')->implode(', ') }}
                                            </div>
                                        @endif
                                    <td class="table-cell text-right">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="table-cell text-right">
                                        ${{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="table-cell text-right">
                                        ${{ number_format($item->tax, 2) }}
                                    </td>
                                    <td class="table-cell text-right font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-gray-200 dark:border-gray-700">
                            <tr>
                                <td colspan="4" class="table-cell"></td>
                                <td class="table-cell text-right font-medium text-gray-600 dark:text-gray-400">Subtotal</td>
                                <td class="table-cell text-right font-medium text-gray-900 dark:text-white">${{ number_format($quote->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table-cell"></td>
                                <td class="table-cell text-right font-medium text-gray-600 dark:text-gray-400">Tax</td>
                                <td class="table-cell text-right font-medium text-gray-900 dark:text-white">${{ number_format($quote->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="table-cell"></td>
                                <td class="table-cell text-right font-medium text-gray-600 dark:text-gray-400">Total</td>
                                <td class="table-cell text-right font-medium text-gray-900 dark:text-white">${{ number_format($quote->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Notes -->
            @if($quote->notes)
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Notes</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-600 dark:text-gray-400">{{ $quote->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Quote History -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Quote History</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <ul class="space-y-2">
                        @foreach($quote->history as $history)
                            <li class="flex items-start">
                                <div class="flex-shrink-0 h-5 w-5 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $history->created_at->format('d/m/Y H:i') }}</span> - 
                                        {{ $history->description }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-footer flex justify-between">
            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quote? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Quote
                </button>
            </form>

            <div class="flex space-x-2">
                <a href="{{ route('quotes.duplicate', $quote) }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Duplicate
                </a>

                <a href="{{ route('quotes.email', $quote) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email Quote
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
