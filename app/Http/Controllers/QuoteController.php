<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use App\Models\Product;
use App\Models\ClientActivity;
use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with('client');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('quote_number', 'like', "%{$search}%")
                  ->orWhereHas('client', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $quotes = $query->latest()->paginate(10);
        
        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('quotes.create', compact('clients', 'products'));
    }

    public function store(StoreQuoteRequest $request)
{
    // Calculate the total for the quote
    $total = 0;
    foreach ($request->items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Create the quote record with all necessary fields, including total
    $quote = Quote::create([
        'client_id' => $request->client_id,
        'quote_number' => $request->quote_number,
        'quote_date' => $request->quote_date,
        'expiry_date' => $request->expiry_date,
        'notes' => $request->notes,
        'terms_and_conditions' => $request->terms_and_conditions,
        'status' => $request->status,
        'total' => $total, // Add total field here
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Add quote items and serial numbers if they exist
    foreach ($request->items as $item) {
        $quoteItem = $quote->items()->create([
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'description' => $item['description'] ?? null
        ]);

        if (isset($item['serial_numbers'])) {
            $serials = explode(',', $item['serial_numbers']);
            foreach ($serials as $serial) {
                $quoteItem->serialNumbers()->create([
                    'product_id' => $item['product_id'],
                    'serial_number' => $serial
                ]);
            }
        }
    }

    // Return the created quote with a response or redirect
    return redirect()->route('quotes.index')->with('success', 'Quote created successfully!');
}


    public function show(Quote $quote)
    {
        $quote->load('client', 'items.product', 'items.serialNumbers');
        
        // Record client activity
        ClientActivity::create([
            'client_id' => $quote->client_id,
            'type' => 'quote_viewed',
            'subject_id' => $quote->id,
            'subject_type' => Quote::class,
            'subject_reference' => $quote->quote_number
        ]);
        
        return view('quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        $clients = Client::all();
        $products = Product::all();
        $quote->load('items.product', 'items.serialNumbers');
        return view('quotes.edit', compact('quote', 'clients', 'products'));
    }

    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        $quote->update($request->validated());
        
        // Delete existing items and serial numbers
        foreach ($quote->items as $item) {
            $item->serialNumbers()->delete();
        }
        $quote->items()->delete();
        
        foreach ($request->items as $item) {
            $quoteItem = $quote->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'description' => $item['description'] ?? null
            ]);
            
            if (isset($item['serial_numbers'])) {
                $serials = explode(',', $item['serial_numbers']);
                foreach ($serials as $serial) {
                    $quoteItem->serialNumbers()->create([
                        'product_id' => $item['product_id'],
                        'serial_number' => trim($serial)
                    ]);
                }
            }
        }
        
        $quote->calculateTotals();
        
        return redirect()->route('quotes.show', $quote)
            ->with('success', 'Quote updated successfully.');
    }

    public function destroy(Quote $quote)
    {
        // Delete all related items and serial numbers
        foreach ($quote->items as $item) {
            $item->serialNumbers()->delete();
        }
        $quote->items()->delete();
        
        $quote->delete();
        
        return redirect()->route('quotes.index')
            ->with('success', 'Quote deleted successfully.');
    }

    public function pdf(Quote $quote)
    {
        $quote->load('client', 'items.product', 'items.serialNumbers');
        $template = Settings::get('quote.default_template', 'default');
        
        $pdf = PDF::loadView("quotes.templates.$template", compact('quote'));
        return $pdf->download("quote_{$quote->quote_number}.pdf");
    }
    
    public function markAs(Request $request, Quote $quote)
    {
        $status = $request->status;
        $validStatuses = ['draft', 'sent', 'approved', 'rejected', 'canceled'];
        
        if (!in_array($status, $validStatuses)) {
            return back()->with('error', 'Invalid status.');
        }
        
        $quote->status = $status;
        $quote->save();
        
        return back()->with('success', "Quote marked as $status.");
    }
    
    public function convertToInvoice(Quote $quote)
    {
        $invoice = $quote->convertToInvoice();
        
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Quote converted to invoice successfully.');
    }
}