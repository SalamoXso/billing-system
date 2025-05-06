@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Edit Invoice #{{ $invoice->invoice_number }}</h1>

                <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Client Selection -->
                    <div class="mb-4">
                        <label for="client_id" class="block text-gray-700">Client</label>
                        <select name="client_id" id="client_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Invoice Items -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Invoice Items</h2>
                        <div id="items-container">
                            @foreach($invoice->items as $index => $item)
                                <div class="item-row mb-4 flex gap-4">
                                    <select name="items[{{ $index }}][product_id]" class="product-select flex-1 rounded-md border-gray-300 shadow-sm">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-has-serial="{{ $product->has_serial ? 'true' : 'false' }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} - ${{ $product->price }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" class="quantity-input w-20 rounded-md border-gray-300 shadow-sm">
                                    <input type="number" name="items[{{ $index }}][price]" value="{{ $item->price }}" step="0.01" min="0" class="price-input w-24 rounded-md border-gray-300 shadow-sm" placeholder="Price">

                                    <!-- Serial Numbers Button -->
                                    <div class="flex items-end">
                                        <button type="button" class="serial-button hidden px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded">
                                            Serial Numbers
                                        </button>
                                    </div>
                                </div>

                                <!-- Serial Numbers Input (Hidden by default) -->
                                <div class="serial-numbers-container hidden mt-4 p-4 border border-gray-200 rounded-md">
                                    <label for="items[0][serial_numbers]" class="block text-gray-700">Serial Numbers (comma separated)</label>
                                    <textarea name="items[0][serial_numbers]" class="serial-numbers mt-1 block w-full rounded-md shadow-sm border-gray-300" rows="2" placeholder="SN001, SN002, ..."></textarea>
                                    <p class="text-gray-500 text-sm mt-1">Enter one serial number per item, separated by commas.</p>
                                </div>

                                <button type="button" class="remove-item bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                            @endforeach
                        </div>
                        <button type="button" id="add-item" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add Item</button>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                            Update Invoice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Client -->
                        <div>
                            <x-label for="client_id" :value="__('Client')" />

                            <select id="client_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $invoice->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Invoice Date -->
                        <div class="mt-4">
                            <x-label for="invoice_date" :value="__('Invoice Date')" />

                            <x-input id="invoice_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="date" name="invoice_date" value="{{ $invoice->invoice_date->format('Y-m-d') }}" required />
                        </div>

                        <!-- Due Date -->
                        <div class="mt-4">
                            <x-label for="due_date" :value="__('Due Date')" />

                            <x-input id="due_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="date" name="due_date" value="{{ $invoice->due_date->format('Y-m-d') }}" required />
                        </div>

                        <!-- Invoice Items -->
                        <div class="mt-4">
                            <x-label :value="__('Invoice Items')" />

                            <div id="invoice-items-container">
                                @foreach($invoice->items as $index => $item)
                                    <div class="invoice-item flex space-x-4 mb-4">
                                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                        <x-input type="text" name="items[{{ $index }}][description]" class="w-1/2 rounded-md border-gray-300 shadow-sm" placeholder="Description" value="{{ $item->description }}" required />
                                        <input type="number" name="items[{{ $index }}][quantity]" class="w-24 rounded-md border-gray-300 shadow-sm" placeholder="Quantity" value="{{ $item->quantity }}" required>
                                        <input type="number" name="items[{{ $index }}][price]" step="0.01" min="0" class="w-24 rounded-md border-gray-300 shadow-sm" placeholder="Price" value="{{ $item->price }}" required>
                                        <!-- Serial Numbers Button -->
                                        <div class="flex items-end">
                                            <button type="button" class="serial-button hidden px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded">
                                                Serial Numbers
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Serial Numbers Input (Hidden by default) -->
                                    <div class="serial-numbers-container hidden mt-4 p-4 border border-gray-200 rounded-md">
                                        <label for="items[0][serial_numbers]" class="block text-gray-700">Serial Numbers (comma separated)</label>
                                        <textarea name="items[0][serial_numbers]" class="serial-numbers mt-1 block w-full rounded-md shadow-sm border-gray-300" rows="2" placeholder="SN001, SN002, ..."></textarea>
                                        <p class="text-gray-500 text-sm mt-1">Enter one serial number per item, separated by commas.</p>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-item-button" class="mt-2 px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">Add Item</button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let itemCount = {{ count($invoice->items) }};

                document.getElementById('add-item-button').addEventListener('click', function () {
                    itemCount++;

                    const container = document.getElementById('invoice-items-container');

                    const itemDiv = document.createElement('div');
                    itemDiv.classList.add('invoice-item', 'flex', 'space-x-4', 'mb-4');

                    itemDiv.innerHTML = `
                        <input type="hidden" name="items[\${itemCount}][id]" value="">
                        <x-input type="text" name="items[\${itemCount}][description]" class="w-1/2 rounded-md border-gray-300 shadow-sm" placeholder="Description" required />
                        <input type="number" name="items[\${itemCount}][quantity]" class="w-24 rounded-md border-gray-300 shadow-sm" placeholder="Quantity" required>
                        <input type="number" name="items[\${itemCount}][price]" step="0.01" min="0" class="w-24 rounded-md border-gray-300 shadow-sm" placeholder="Price" required>
                                    <!-- Serial Numbers Button -->
                                    <div class="flex items-end">
                                        <button type="button" class="serial-button hidden px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded">
                                            Serial Numbers
                                        </button>
                                    </div>
                                </div>

                                <!-- Serial Numbers Input (Hidden by default) -->
                                <div class="serial-numbers-container hidden mt-4 p-4 border border-gray-200 rounded-md">
                                    <label for="items[0][serial_numbers]" class="block text-gray-700">Serial Numbers (comma separated)</label>
                                    <textarea name="items[0][serial_numbers]" class="serial-numbers mt-1 block w-full rounded-md shadow-sm border-gray-300" rows="2" placeholder="SN001, SN002, ..."></textarea>
                                    <p class="text-gray-500 text-sm mt-1">Enter one serial number per item, separated by commas.</p>
                                </div>
                    `;

                    container.appendChild(itemDiv);
                });
            });
        </script>
    @endpush
</x-app-layout>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('items-container');
        document.getElementById('add-item').addEventListener('click', function() {
            const itemCount = container.querySelectorAll('.item-row').length;
            const newItem = document.createElement('div');
            newItem.className = 'item-row mb-4 flex gap-4';
            newItem.innerHTML = `
                <select name="items[\${itemCount}][product_id]" class="flex-1 rounded-md border-gray-300 shadow-sm">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                    @endforeach
                </select>
                <input type="number" name="items[\${itemCount}][quantity]" value="1" min="1" class="w-20 rounded-md border-gray-300 shadow-sm">
                <input type="number" name="items[\${itemCount}][price]" step="0.01" min="0" class="w-24 rounded-md border-gray-300 shadow-sm" placeholder="Price">
                <button type="button" class="remove-item bg-red-500 text-white px-2 py-1 rounded">Remove</button>
            `;
            container.appendChild(newItem);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });
    });
</script>
@endsection
