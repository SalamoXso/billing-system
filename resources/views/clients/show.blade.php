@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Client Details</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('clients.edit', $client) }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-bold rounded">
                            Edit Client
                        </a>
                        <a href="{{ route('invoices.create') }}?client_id={{ $client->id }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                            Create Invoice
                        </a>
                    </div>
                </div>
                
                <!-- Client Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Contact Information</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600 dark:text-gray-400"><span class="font-semibold">Name:</span> {{ $client->name }}</p>
                            <p class="text-gray-600 dark:text-gray-400"><span class="font-semibold">Email:</span> {{ $client->email }}</p>
                            <p class="text-gray-600 dark:text-gray-400"><span class="font-semibold">Phone:</span> {{ $client->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Address</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600 dark:text-gray-400">{{ $client->address ?? 'No address provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Client Invoices -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Invoices</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Invoice #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Due Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $invoice->invoice_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $invoice->invoice_date->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $invoice->due_date->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                ${{ number_format($invoice->total, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mr-3">View</a>
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-3">Edit</a>
                                            <a href="{{ route('invoices.pdf', $invoice) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600">PDF</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No invoices found for this client.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection