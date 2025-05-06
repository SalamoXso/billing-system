@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Edit Quote #{{ $quote->quote_number }}</h1>

                <form action="{{ route('quotes.update', $quote) }}" method="POST">
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

                    <!-- Quote Items -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Quote Items</h2>
                        <div id="items-container">
                            @foreach($quote->items as $index => $item)
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
                                <!-- Serial Numbers -->
                                <div class="serial-numbers-container hidden mt-2">
                                    <label for="items[0][serial_numbers]" class="block text-gray-700">Serial Numbers (comma separated)</label>
                                    <input type="text" name="items[0][serial_numbers]" class="serial-numbers rounded-md shadow-sm border-gray-300" placeholder="SN001, SN002, ...">
                                </div>
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
