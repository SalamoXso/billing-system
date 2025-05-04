@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container mx-auto">
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Invoices</h2>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create New Invoice
            </a>
        </div>
        
        <div class="card-body">
            <!-- Filter Tabs -->
            <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="mr-2">
                        <a href="{{ route('invoices.index') }}" class="inline-block p-4 {{ !request('status') || request('status') == 'all' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            All
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="{{ route('invoices.index', ['status' => 'draft']) }}" class="inline-block p-4 {{ request('status') == 'draft' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Draft
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="{{ route('invoices.index', ['status' => 'sent']) }}" class="inline-block p-4 {{ request('status') == 'sent' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Sent
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="{{ route('invoices.index', ['status' => 'paid']) }}" class="inline-block p-4 {{ request('status') == 'paid' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Paid
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="{{ route('invoices.index', ['status' => 'overdue']) }}" class="inline-block p-4 {{ request('status') == 'overdue' ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-500 dark:border-blue-500' : 'text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Overdue
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('invoices.index') }}" method="GET" class="mb-6">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div class="flex">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" placeholder="Search invoices..." value="{{ request('search') }}" 
                            class="form-input pl-10">
                    </div>
                    <button type="submit" class="ml-3 btn btn-primary">
                        Search
                    </button>
                </div>
            </form>
            
            <!-- Invoices Table -->
            <div class="table-container">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-header-cell">Invoice #</th>
                            <th class="table-header-cell">Client</th>
                            <th class="table-header-cell">Date</th>
                            <th class="table-header-cell">Due Date</th>
                            <th class="table-header-cell">Status</th>
                            <th class="table-header-cell">Total</th>
                            <th class="table-header-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse ($invoices as $invoice)
                            <tr class="table-row">
                                <td class="table-cell font-medium text-gray-900 dark:text-white">
                                    {{ $invoice->invoice_number }}
                                </td>
                                <td class="table-cell">
                                    {{ $invoice->client->name }}
                                </td>
                                <td class="table-cell">
                                    {{ $invoice->invoice_date->format('d/m/Y') }}
                                </td>
                                <td class="table-cell">
                                    {{ $invoice->due_date->format('d/m/Y') }}
                                </td>
                                <td class="table-cell">
                                    <span class="badge 
                                        @if($invoice->status == 'draft') badge-gray
                                        @elseif($invoice->status == 'sent') badge-info
                                        @elseif($invoice->status == 'paid') badge-success
                                        @elseif($invoice->status == 'overdue') badge-danger
                                        @endif">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="table-cell font-medium">
                                    ${{ number_format($invoice->total, 2) }}
                                </td>
                                <td class="table-cell">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('invoices.pdf', $invoice) }}" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="PDF">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete" onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="table-cell text-center py-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2  stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">No invoices found.</p>
                                        <a href="{{ route('invoices.create') }}" class="mt-4 btn btn-primary">
                                            Create Your First Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
