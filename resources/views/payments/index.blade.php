@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Payments</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            Record Payment
        </a>
    </div>

    <div class="dashboard-card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Payment #</th>
                        <th>Invoice</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="font-medium">PAY-{{ 2023 + $i }}</td>
                        <td>INV-{{ 2023 + $i }}</td>
                        <td>Client {{ $i }}</td>
                        <td>{{ date('M d, Y', strtotime("-$i days")) }}</td>
                        <td>${{ number_format($i * 800, 2) }}</td>
                        <td>
                            {{ ['Credit Card', 'Bank Transfer', 'PayPal', 'Cash'][$i % 4] }}
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('payments.show', $i) }}" class="text-gray-500 dark:text-gray-400 hover:text-[#26a6df] dark:hover:text-[#26a6df]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="#" onclick="window.print()" class="text-gray-500 dark:text-gray-400 hover:text-[#26a6df] dark:hover:text-[#26a6df]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                        <rect x="6" y="14" width="12" height="8"></rect>
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
