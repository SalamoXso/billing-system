@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Create New Invoice</h1>

                <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client Selection -->
                        <div>
                            <label for="client_id" class="block text-gray-700">Client</label>
                            <select name="client_id" id="client_id" class="rounded-md shadow-sm border-gray-300" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Invoice Number -->
                        <div>
                            <label for="invoice_number" class="block text-gray-700">Invoice Number</label>
                            <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', 'INV-' . date('Ymd') . '-' . rand(100, 999)) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('invoice_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Invoice Date -->
                        <div>
                            <label for="invoice_date" class="block text-gray-700">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('invoice_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label for="due_date" class="block text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('due_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-3">Invoice Items</h3>

                        <div id="invoice-items" class="space-y-4">
                            <div class="invoice-item bg-gray-100 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Product -->
                                    <div>
                                        <label for="items[0][product_id]" class="block text-gray-700">Product</label>
                                        <select name="items[0][product_id]" class="product-select rounded-md shadow-sm border-gray-300" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-has-serial="{{ $product->has_serial ? 'true' : 'false' }}">
                                                    {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Quantity -->
                                    <div>
                                        <label for="items[0][quantity]" class="block text-gray-700">Quantity</label>
                                        <input type="number" name="items[0][quantity]" class="quantity-input rounded-md shadow-sm border-gray-300" min="1" value="1" required>
                                    </div>

                                    <!-- Price (inc GST) -->
                                    <div>
                                        <label for="items[0][price]" class="block text-gray-700">Price (inc GST)</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">$</span>
                                            </div>
                                            <input type="number" name="items[0][price]" class="price-input pl-7 rounded-md shadow-sm border-gray-300" step="0.01" min="0" required>
                                        </div>
                                    </div>

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

                                <!-- Remove Button (hidden for first item) -->
                                <div class="mt-2 text-right">
                                    <button type="button" class="remove-item text-red-600 hover:text-red-900 text-sm hidden">
                                        Remove Item
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add Item Button -->
                        <div class="mt-4">
                            <button type="button" id="add-item" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                                Add Item
                            </button>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-6">
                        <label for="notes" class="block text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="rounded-md shadow-sm border-gray-300"></textarea>
                        @error('notes')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Create Invoice
                        </button>
                        <!-- Serial Numbers Button -->
                        <div class="flex items-end">
                                        <button type="button" class="serial-button hidden px-4
py-2   bg-gray-200   hover:bg-gray-300   dark:bg-gray-600   dark:hover:bg-gray-500   text-gray-700
dark:text-gray-200 font-medium rounded">
                                            Serial Numbers
                                        </button>
                                    </div>
                                <!-- Serial Numbers Input (Hidden by default) -->
                                <div class="serial-numbers-container hidden mt-4 p-4 border
border-gray-200 dark:border-gray-600 rounded-md">
                                    <label for="items[0][serial_numbers]" class="block text-sm
font-medium text-gray-700 dark:text-gray-300">Serial Numbers (comma separated)</label>
                                                                        <textarea  name="items[0][serial_numbers]"
class="serial-numbers  mt-1  block  w-full  border-gray-300  dark:border-gray-700  dark:bg-gray-900
dark:text-gray-300   focus:border-indigo-500   dark:focus:border-indigo-600   focus:ring-indigo-500
dark:focus:ring-indigo-600    rounded-md    shadow-sm"    rows="2"    placeholder="SN001,    SN002,
..."></textarea>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter
one serial number per item, separated by commas.</p>
                                </div>
           

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 0;

        // Initialize the first item
        initializeItem(0);

        // Add new item
        document.getElementById('add-item').addEventListener('click', function() {
            itemCount++;

            const itemsContainer = document.getElementById('invoice-items');
            const newItem = document.querySelector('.invoice-item').cloneNode(true);

            // Update input names and IDs
            newItem.querySelectorAll('select, input, textarea, button').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${itemCount}]`));
                }

                // Clear values
                if (input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                } else if (input.type === 'number') {
                    if (input.classList.contains('quantity-input')) {
                        input.value = 1;
                    } else {
                        input.value = '';
                    }
                } else if (input.tagName === 'TEXTAREA') {
                    input.value = '';
                }
            });

            // Show remove button
            const removeButton = newItem.querySelector('.remove-item');
            removeButton.classList.remove('hidden');

            // Hide serial button and container initially
            const serialButton = newItem.querySelector('.serial-button');
            serialButton.classList.add('hidden');
            const serialContainer = newItem.querySelector('.serial-numbers-container');
            serialContainer.classList.add('hidden');

            // Add event listeners
            initializeItemEvents(newItem, itemCount);

            // Add to container
            itemsContainer.appendChild(newItem);
        });

        // Initialize the first item's event listeners
        function initializeItem(index) {
            const item = document.querySelector('.invoice-item');
            initializeItemEvents(item, index);

            // Show remove button for all but the first item
            if (index > 0) {
                item.querySelector('.remove-item').classList.remove('hidden');
            }
        }

        // Initialize event listeners for an item
        function initializeItemEvents(item, index) {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const priceInput = item.querySelector('.price-input');
            const serialButton = item.querySelector('.serial-button');
            const serialContainer = item.querySelector('.serial-numbers-container');
            const removeButton = item.querySelector('.remove-item');

            // Product selection changes
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    priceInput.value = selectedOption.dataset.price;

                    // Show/hide serial numbers button
                    if (selectedOption.dataset.hasSerial === 'true') {
                        serialButton.classList.remove('hidden');
                    } else {
                        serialButton.classList.add('hidden');
                        serialContainer.classList.add('hidden');
                    }
                } else {
                    priceInput.value = '';
                    serialButton.classList.add('hidden');
                    serialContainer.classList.add('hidden');
                }
            });

            // Serial numbers button click
            serialButton.addEventListener('click', function() {
                serialContainer.classList.toggle('hidden');
                this.textContent = serialContainer.classList.contains('hidden') ? 'Serial Numbers' : 'Hide Serial Numbers';
            });

            // Remove item
            removeButton.addEventListener('click', function() {
                item.remove();
            });
        }
    });
     // Serial numbers button click
     serialButton.addEventListener('click', function() {
                serialContainer.classList.toggle('hidden');
                this.textContent = serialContainer.classList.contains('hidden') ? 'Serial Numbers'
: 'Hide Serial Numbers';
            });
</script>
@endsection
