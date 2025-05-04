@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Invoices</h1>
                    <a href="{{ route('invoices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Create New Invoice
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Invoice #</th>
                                <th class="px-4 py-2">Client</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Due Date</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td class="px-4 py-2">{{ $invoice->invoice_number }}</td>
                                <td class="px-4 py-2">{{ $invoice->client->name }}</td>
                                <td class="px-4 py-2">{{ $invoice->invoice_date->format('m/d/Y') }}</td>
                                <td class="px-4 py-2">{{ $invoice->due_date->format('m/d/Y') }}</td>
                                <td class="px-4 py-2">${{ number_format($invoice->total, 2) }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="bg-blue-500 text-white px-2 py-1 rounded">View</a>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                                    </form>
                                    <a href="{{ route('invoices.pdf', $invoice) }}" class="bg-green-500 text-white px-2 py-1 rounded">PDF</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection