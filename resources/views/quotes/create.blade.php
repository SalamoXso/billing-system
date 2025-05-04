@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Create New Quote</h2>
                </div>

                <form action="{{ route('quotes.store') }}" method="POST" id="quote-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client Selection -->
                        <div>
                            <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client</label>
                            <select name="client_id" id="client_id" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quote Number -->
                        <div>
                            <label for="quote_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quote Number</label>
                            <input type="text" name="quote_number" id="quote_number" value="{{ old('quote_number', 'QUO' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)) }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @error('quote_number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quote Date -->
                        <div>
                            <label for="quote_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quote Date</label>
                            <input type="date" name="quote_date" id="quote_date" value="{{ old('quote_date', date('Y-m-d')) }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @error('quote_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', date('Y-m-d', strtotime('+30 days'))) }}" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @error('expiry_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Quote Items -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Quote Items</h3>
                        
                        <div id="quote-items" class="space-y-4">
                            <div class="quote-item bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <!-- Product -->
                                    <div class="md:col-span-2">
                                        <label for="items[0][product_id]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                                        <select name="items[0][product_id]" class="product-select mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
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
                                        <label for="items[0][quantity]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                                        <input type="number" name="items[0][quantity]" class="quantity-input mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" min="1" value="1" required>
                                    </div>

                                    <!-- Price -->
                                    <div>
                                        <label for="items[0][price]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                                        <input type="number" name="items[0][price]" class="price-input mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" step="0.01" min="0" required>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-end">
                                        <button type="button" class="remove-item text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 text-sm hidden">
                                            Remove Item
                                        </button>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mt-2">
                                    <label for="items[0][description]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea name="items[0][description]" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="2"></textarea>
                                </div>

                                <!-- Serial Numbers -->
                                <div class="serial-numbers-container hidden mt-2">
                                    <label for="items[0][serial_numbers]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial Numbers (comma separated)</label>
                                    <input type="text" name="items[0][serial_numbers]" class="serial-numbers mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="SN001, SN002, ...">
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
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <label for="terms_and_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Terms and Conditions</label>
                        <textarea name="terms_and_conditions" id="terms_and_conditions" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('terms_and_conditions') }}</textarea>
                        @error('terms_and_conditions')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('quotes.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 mr-4">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded">
                            Create Quote
                        </button>
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
        
        const itemsContainer = document.getElementById('quote-items');
        const newItem = document.querySelector('.quote-item').cloneNode(true);
        
        // Update input names and IDs
        newItem.querySelectorAll('select, input, textarea').forEach(input => {
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
            } else {
                input.value = '';
            }
        });
        
        // Show remove button
        const removeButton = newItem.querySelector('.remove-item');
        removeButton.classList.remove('hidden');
        
        // Add event listeners
        initializeItemEvents(newItem, itemCount);
        
        // Add to container
        itemsContainer.appendChild(newItem);
    });
    
    // Initialize the first item's event listeners
    function initializeItem(index) {
        const item = document.querySelector('.quote-item');
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
        const serialContainer = item.querySelector('.serial-numbers-container');
        const removeButton = item.querySelector('.remove-item');
        
        // Product selection changes
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                priceInput.value = selectedOption.dataset.price;
                
                // Show/hide serial numbers field
                if (selectedOption.dataset.hasSerial === 'true') {
                    serialContainer.classList.remove('hidden');
                } else {
                    serialContainer.classList.add('hidden');
                }
            } else {
                priceInput.value = '';
                serialContainer.classList.add('hidden');
            }
        });
        
        // Remove item
        removeButton.addEventListener('click', function() {
            item.remove();
        });
    }
});
</script>
@endsection