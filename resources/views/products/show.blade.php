@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Product Details</h2>
                    <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded">
                        Edit Product
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                    </div>

                    <!-- Price (inc GST) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price (inc GST)</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $product->description }}</div>
                </div>

                <!-- Has Serial Number -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Has Serial Number</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $product->has_serial ? 'Yes' : 'No' }}
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
