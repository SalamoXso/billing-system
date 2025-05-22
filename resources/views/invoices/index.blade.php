@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            Create Invoice
        </a>
    </div>

    <div class="dashboard-card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="font-medium">INV-{{ 2023 + $i }}</td>
                        <td>Client {{ $i }}</td>
                        <td>{{ date('M d, Y', strtotime("-$i days")) }}</td>
                        <td>{{ date('M d, Y', strtotime("+$i days")) }}</td>
                        <td>${{ number_format($i * 1000, 2) }}</td>
                        <td>
                            <span class="badge {{ $i % 3 === 0 ? 'badge-warning' : ($i % 4 === 0 ? 'badge-danger' : 'badge-success') }}">
                                {{ $i % 3 === 0 ? 'Pending' : ($i % 4 === 0 ? 'Overdue' : 'Paid') }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('invoices.edit', $i) }}" class="text-gray-500 dark:text-gray-400 hover:text-[#26a6df] dark:hover:text-[#26a6df]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('invoices.show', $i) }}" class="text-gray-500 dark:text-gray-400 hover:text-[#26a6df] dark:hover:text-[#26a6df]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
