@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Invoice Summary Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Invoice Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Draft Invoices -->
                <div class="bg-amber-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($draftInvoicesTotal, 2) }}</div>
                        <div class="text-sm">Draft Invoices</div>
                    </div>
                    <div class="bg-amber-600 p-2 text-center">
                        <a href="{{ route('invoices.index', ['status' => 'draft']) }}" class="text-white text-sm hover:underline">
                            View Draft Invoices
                        </a>
                    </div>
                </div>

                <!-- Sent Invoices -->
                <div class="bg-cyan-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($sentInvoicesTotal, 2) }}</div>
                        <div class="text-sm">Sent Invoices</div>
                    </div>
                    <div class="bg-cyan-600 p-2 text-center">
                        <a href="{{ route('invoices.index', ['status' => 'sent']) }}" class="text-white text-sm hover:underline">
                            View Sent Invoices
                        </a>
                    </div>
                </div>

                <!-- Overdue Invoices -->
                <div class="bg-red-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($overdueInvoicesTotal, 2) }}</div>
                        <div class="text-sm">Overdue Invoices</div>
                    </div>
                    <div class="bg-red-600 p-2 text-center">
                        <a href="{{ route('invoices.index', ['status' => 'overdue']) }}" class="text-white text-sm hover:underline">
                            View Overdue Invoices
                        </a>
                    </div>
                </div>

                <!-- Payments Collected -->
                <div class="bg-green-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($paymentsCollected, 2) }}</div>
                        <div class="text-sm">Payments Collected</div>
                    </div>
                    <div class="bg-green-600 p-2 text-center">
                        <a href="{{ route('payments.index') }}" class="text-white text-sm hover:underline">
                            View Payments
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quote Summary Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Quote Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Draft Quotes -->
                <div class="bg-purple-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($draftQuotesTotal, 2) }}</div>
                        <div class="text-sm">Draft Quotes</div>
                    </div>
                    <div class="bg-purple-600 p-2 text-center">
                        <a href="{{ route('quotes.index', ['status' => 'draft']) }}" class="text-white text-sm hover:underline">
                            View Draft Quotes
                        </a>
                    </div>
                </div>

                <!-- Sent Quotes -->
                <div class="bg-emerald-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($sentQuotesTotal, 2) }}</div>
                        <div class="text-sm">Sent Quotes</div>
                    </div>
                    <div class="bg-emerald-600 p-2 text-center">
                        <a href="{{ route('quotes.index', ['status' => 'sent']) }}" class="text-white text-sm hover:underline">
                            View Sent Quotes
                        </a>
                    </div>
                </div>

                <!-- Rejected Quotes -->
                <div class="bg-orange-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($rejectedQuotesTotal, 2) }}</div>
                        <div class="text-sm">Rejected Quotes</div>
                    </div>
                    <div class="bg-orange-600 p-2 text-center">
                        <a href="{{ route('quotes.index', ['status' => 'rejected']) }}" class="text-white text-sm hover:underline">
                            View Rejected Quotes
                        </a>
                    </div>
                </div>

                <!-- Approved Quotes -->
                <div class="bg-blue-500 text-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <div class="text-2xl font-bold">${{ number_format($approvedQuotesTotal, 2) }}</div>
                        <div class="text-sm">Approved Quotes</div>
                    </div>
                    <div class="bg-blue-600 p-2 text-center">
                        <a href="{{ route('quotes.index', ['status' => 'approved']) }}" class="text-white text-sm hover:underline">
                            View Approved Quotes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Client Activity -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Recent Client Activity</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Activity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($recentActivities as $activity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if ($activity->type === 'invoice_viewed')
                                            Invoice <a href="{{ route('invoices.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a> was viewed.
                                        @elseif ($activity->type === 'quote_viewed')
                                            Quote <a href="{{ route('quotes.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a> was viewed.
                                        @elseif ($activity->type === 'payment_received')
                                            Payment of ${{ number_format($activity->amount, 2) }} was received for Invoice <a href="{{ route('invoices.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a>.
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                        No recent activity.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection