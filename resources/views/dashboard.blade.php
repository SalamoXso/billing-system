@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Draft Invoices -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-l-4 border-amber-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Draft Invoices
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-200">
                                ${{ number_format($draftInvoicesTotal, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('invoices.index', ['status' => 'draft']) }}" class="text-sm font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400 dark:hover:text-amber-300">
                    View all drafts &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Sent Invoices -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Sent Invoices
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-200">
                                ${{ number_format($sentInvoicesTotal, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('invoices.index', ['status' => 'sent']) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    View all sent invoices &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Overdue Invoices -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Overdue Invoices
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-200">
                                ${{ number_format($overdueInvoicesTotal, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('invoices.index', ['status' => 'overdue']) }}" class="text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300">
                    View overdue invoices &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Payments Collected -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                            Payments Collected
                        </dt>
                        <dd>
                            <div class="text-lg font-medium text-gray-900 dark:text-gray-200">
                                ${{ number_format($paymentsCollected, 2) }}
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('payments.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300">
                    View all payments &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quote Summary Section -->
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Quote Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Draft Quotes -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                Draft Quotes
                            </dt>
                            <dd>
                                <div class="text-lg font-medium text-gray-900 dark:text-gray-200">
                                    ${{ number_format($draftQuotesTotal, 2) }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('quotes.index', ['status' => 'draft']) }}" class="text-sm font-medium text-purple-600 hover:text-purple-500 dark:text-purple-400 dark:hover:text-purple-300">
                        View draft quotes &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Other quote cards follow the same pattern -->
    </div>
</div>

<!-- Recent Client Activity -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
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
            @switch($activity->type)
                @case('invoice_viewed')
                    Invoice <a href="{{ route('invoices.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a> was viewed.
                    @break
                @case('quote_viewed')
                    Quote <a href="{{ route('quotes.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a> was viewed.
                    @break
                @case('payment_received')
                    Payment of ${{ number_format($activity->amount, 2) }} was received for Invoice <a href="{{ route('invoices.show', $activity->subject_id) }}" class="text-blue-600 hover:underline">#{{ $activity->subject_reference }}</a>.
                    @break
            @endswitch
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
@endsection
