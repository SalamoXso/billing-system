@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        Quote #{{ $quote->quote_number }}
                        <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full 
                            @if($quote->status == 'draft') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                            @elseif($quote->status == 'sent') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($quote->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($quote->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($quote->status == 'canceled') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @endif">
                            {{ ucfirst($quote->status) }}
                        </span>
                    </h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('quotes.pdf', $quote) }}" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                            Download PDF
                        </a>
                        <a href="{{ route('quotes.edit', $quote) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                            Edit
                        </a>
                        @if($quote->status == 'draft')
                            <form action="{{ route('quotes.mark-as', $quote) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="sent">
                                <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold rounded">
                                    Mark as Sent
                                </button>
                            </form>
                        @endif
                        @if($quote->status == 'sent')
                            <div class="flex space-x-2">
                                <form action="{{ route('quotes.mark-as', $quote) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                                        Mark as Approved
                                    </button>
                                </form>
                                <form action="{{ route('quotes.mark-as', $quote) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white font-bold rounded">
                                        Mark as Rejected
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if($quote->status == 'approved' || $quote->status == 'sent')
                            <form action="{{ route('quotes.convert', $quote) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-purple-500 hover:bg-purple-700 text-white font-bold rounded">
                                    Convert to Invoice
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">From</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                            <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ config('app.name') }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ Settings::get('company.address') }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ Settings::get('company.phone') }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ Settings::get('company.email') }}</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">To</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                            <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $quote->client->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $quote->client->address }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $quote->client->phone }}</p>
                            <p class="text-gray-600 dark:text-gray-400">{{ $quote->client->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Quote Number</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $quote->quote_number }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Quote Date</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $quote->quote_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</h3>
                        <p class="text-gray-800 dark:text-gray-200">{{ $quote->expiry_date->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price (inc GST)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total (inc GST)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($quote->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->product->name }}
                                        @if($item->serialNumbers->count() > 0)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <strong>Serial Numbers:</strong> 
                                                {{ $item->serialNumbers->pluck('serial_number')->implode(', ') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        ${{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mb-6">
                    <div class="w-full md:w-1/3">
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">Subtotal (ex GST):</span>
                            <span class="text-gray-800 dark:text-gray-200">${{ number_format($quote->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300">GST (10%):</span>
                            <span class="text-gray-800 dark:text-gray-200">${{ number_format($quote->gst_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 font-semibold">
                            <span class="text-gray-700 dark:text-gray-300">Total:</span>
                            <span class="text-gray-800 dark:text-gray-200">${{ number_format($quote->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if($quote->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        <p class="text-gray-600 dark:text-gray-400">{{ $quote->notes }}</p>
                    </div>
                </div>
                @endif

                @if($quote->terms_and_conditions)
                <div>
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Terms and Conditions</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        <p class="text-gray-600 dark:text-gray-400">{{ $quote->terms_and_conditions }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection