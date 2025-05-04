@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Invoice #{{ $invoice->invoice_number }}</h1>
                
                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Client Information</h2>
                    <p>{{ $invoice->client->name }}</p>
                    <p>{{ $invoice->client->email }}</p>
                </div>

                <table class="min-w-full mb-6">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Product</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-right">
                    <p class="font-bold">Subtotal: ${{ number_format($invoice->subtotal, 2) }}</p>
                    <p>GST (10%): ${{ number_format($invoice->gst_amount, 2) }}</p>
                    <p class="text-xl font-bold">Total: ${{ number_format($invoice->total, 2) }}</p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('invoices.pdf', $invoice) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Download PDF
                    </a>
                    <a href="{{ route('invoices.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection