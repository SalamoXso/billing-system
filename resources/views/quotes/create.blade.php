@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold mb-4">Create New Quote</h1>

                <form action="{{ route('quotes.store') }}" method="POST" id="quote-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Client Selection -->
                        <div>
                            <label for="client_id" class="block text-gray-700">Client</label>
                            <select name="client_id" id="client_id" class="rounded-md shadow-sm border-gray-300" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quote Number -->
                        <div>
                            <label for="quote_number" class="block text-gray-700">Quote Number</label>
                            <input type="text" name="quote_number" id="quote_number" value="{{ old('quote_number', 'QUO' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('quote_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quote Date -->
                        <div>
                            <label for="quote_date" class="block text-gray-700">Quote Date</label>
                            <input type="date" name="quote_date" id="quote_date" value="{{ old('quote_date', date('Y-m-d')) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('quote_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="expiry_date" class="block text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', date('Y-m-d', strtotime('+30 days'))) }}" required class="rounded-md shadow-sm border-gray-300">
                            @error('expiry_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-gray-700">Status</label>
                            <select name="status" id="status" required class="rounded-md shadow-sm border-gray-300">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Quote Items -->
                    <div class="mt-6">
                        <h3 class="text-xl font-semibold mb-3">Quote Items</h3>

                        <div id="quote-items" class="space-y-4">
                            <div class="quote-item bg-gray-100 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                    <!-- Product -->
                                    <div class="md:col-span-2">
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

                                    <!-- Price -->
                                    <div>
                                        <label for="items[0][price]" class="block text-gray-700">Price</label>
                                        <input type="number" name="items[0][price]" class="price-input rounded-md shadow-sm border-gray-300" step="0.01" min="0" required>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-end">
                                        <button type="button" class="remove-item text-red-600 hover:text-red-900 text-sm hidden">
                                            Remove Item
                                        </button>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mt-2">
                                    <label for="items[0][description]" class="block text-gray-700">Description</label>
                                    <textarea name="items[0][description]" class="rounded-md shadow-sm border-gray-300" rows="2"></textarea>
                                </div>

                                <!-- Serial Numbers -->
                                <div class="serial-numbers-container hidden mt-2">
                                    <label for="items[0][serial_numbers]" class="block text-gray-700">Serial Numbers (comma separated)</label>
                                    <input type="text" name="items[0][serial_numbers]" class="serial-numbers rounded-md shadow-sm border-gray-300" placeholder="SN001, SN002, ...">
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

                    <!-- Terms and Conditions -->
                    <div class="mt-6">
                        <label for="terms_and_conditions" class="block text-gray-700">Terms and Conditions</label>
                        <textarea name="terms_and_conditions" id="terms_and_conditions" rows="3" class="rounded-md shadow-sm border-gray-300"></textarea>
                        @error('terms_and_conditions')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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
        newItem.querySelectorAll('select, input, textarea').forEach((element) => {
            element.name = element.name.replace(/\[\d\]/, `[${itemCount}]`);
            element.id = element.id.replace(/\[\d\]/, `[${itemCount}]`);
            element.value = '';
        });

        // Show/hide serial number field based on selected product
        const productSelect = newItem.querySelector('.product-select');
        productSelect.addEventListener('change', function() {
            const serialContainer = newItem.querySelector('.serial-numbers-container');
            const selectedOption = productSelect.selectedOptions[0];
            serialContainer.classList.toggle('hidden', selectedOption.dataset.hasSerial === 'false');
        });

        // Add the item to the container
        itemsContainer.appendChild(newItem);
        initializeItem(itemCount);
    });

    // Function to initialize an item
    function initializeItem(index) {
        const item = document.querySelectorAll('.quote-item')[index];
        const productSelect = item.querySelector('.product-select');
        productSelect.addEventListener('change', function() {
            const serialContainer = item.querySelector('.serial-numbers-container');
            const selectedOption = productSelect.selectedOptions[0];
            serialContainer.classList.toggle('hidden', selectedOption.dataset.hasSerial === 'false');
        });

        // Remove item functionality
        const removeButton = item.querySelector('.remove-item');
        removeButton.addEventListener('click', function() {
            item.remove();
        });
    }
});
</script>
@endsection
