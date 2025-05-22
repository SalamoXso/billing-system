@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            Create Invoice
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="dashboard-card">
            <div class="flex justify-between items-start">
                <div>
                    <div class="dashboard-card-title">Total Invoices</div>
                    <div class="dashboard-card-value">142</div>
                    <div class="dashboard-card-subtitle">+12% from last month</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="flex justify-between items-start">
                <div>
                    <div class="dashboard-card-title">Active Clients</div>
                    <div class="dashboard-card-value">24</div>
                    <div class="dashboard-card-subtitle">+2 new this month</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="flex justify-between items-start">
                <div>
                    <div class="dashboard-card-title">Revenue</div>
                    <div class="dashboard-card-value">$12,234</div>
                    <div class="dashboard-card-subtitle">+18.2% from last month</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="flex justify-between items-start">
                <div>
                    <div class="dashboard-card-title">Products</div>
                    <div class="dashboard-card-value">36</div>
                    <div class="dashboard-card-subtitle">+3 added this month</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500">
                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <h2 class="text-lg font-medium mb-2 text-gray-900 dark:text-white">Recent Invoices</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Your most recent invoices</p>
        
        <div class="space-y-2">
            @for ($i = 1; $i <= 5; $i++)
            <div class="flex items-center justify-between border border-gray-100 dark:border-gray-700 rounded-lg p-3 bg-white dark:bg-gray-800">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#26a6df" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">INV-{{ 2023 + $i }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Client {{ $i }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($i * 1000) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Due in {{ $i * 5 }} days</p>
                    </div>
                    <div class="h-2 w-2 rounded-full {{ $i % 2 === 0 ? 'bg-green-500' : 'bg-amber-500' }}"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
