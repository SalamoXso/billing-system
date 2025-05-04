<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use App\Models\Settings;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }
    
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('invoices.create', compact('clients', 'products'));
    }
    
    public function store(StoreInvoiceRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Create the invoice
            $invoice = Invoice::create([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes,
                'subtotal' => 0, // Will be calculated later
                'gst_amount' => 0, // Will be calculated later
                'total' => 0, // Will be calculated later
            ]);
            
            // Process invoice items
            foreach ($request->items as $item) {
                $invoiceItem = $invoice->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // Process serial numbers if provided
                if (isset($item['serial_numbers']) && !empty($item['serial_numbers'])) {
                    $serials = array_map('trim', explode(',', $item['serial_numbers']));
                    
                    // Validate that the number of serial numbers matches the quantity
                    if (count($serials) != $item['quantity']) {
                        throw new \Exception('The number of serial numbers must match the quantity.');
                    }
                    
                    foreach ($serials as $serial) {
                        $invoiceItem->serialNumbers()->create([
                            'product_id' => $item['product_id'],
                            'serial_number' => $serial
                        ]);
                    }
                }
            }
            
            // Calculate totals
            $invoice->calculateTotals();
            
            // Increment the next invoice number in settings
            $nextNumber = (int) Settings::get('invoice.next_number', 1001);
            Settings::set('invoice.next_number', $nextNumber + 1);
            
            DB::commit();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }
    
    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'items.product', 'items.serialNumbers');
        return view('invoices.show', compact('invoice'));
    }
    
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $invoice->load('items.product', 'items.serialNumbers');
        return view('invoices.edit', compact('invoice', 'clients', 'products'));
    }
    
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        DB::beginTransaction();
        
        try {
            // Update invoice details
            $invoice->update([
                'client_id' => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes,
            ]);
            
            // Delete existing items and serial numbers
            foreach ($invoice->items as $item) {
                $item->serialNumbers()->delete();
            }
            $invoice->items()->delete();
            
            // Process new items
            foreach ($request->items as $item) {
                $invoiceItem = $invoice->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // Process serial numbers if provided
                if (isset($item['serial_numbers']) && !empty($item['serial_numbers'])) {
                    $serials = array_map('trim', explode(',', $item['serial_numbers']));
                    
                    // Validate that the number of serial numbers matches the quantity
                    if (count($serials) != $item['quantity']) {
                        throw new \Exception('The number of serial numbers must match the quantity.');
                    }
                    
                    foreach ($serials as $serial) {
                        $invoiceItem->serialNumbers()->create([
                            'product_id' => $item['product_id'],
                            'serial_number' => $serial
                        ]);
                    }
                }
            }
            
            // Recalculate totals
            $invoice->calculateTotals();
            
            DB::commit();
            
            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating invoice: ' . $e->getMessage());
        }
    }
    
    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();
        
        try {
            // Delete all related items and serial numbers
            foreach ($invoice->items as $item) {
                $item->serialNumbers()->delete();
            }
            $invoice->items()->delete();
            
            // Delete the invoice
            $invoice->delete();
            
            DB::commit();
            
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting invoice: ' . $e->getMessage());
        }
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load('client', 'items.product', 'items.serialNumbers');
        $template = Settings::get('invoice.default_template', 'custom');
        
        // Get company information from settings
        $companyName = Settings::get('company.name', 'Your Company Name');
        $companyAddress = Settings::get('company.address', '123 Business Street, City, State ZIP');
        $companyPhone = Settings::get('company.phone', '(123) 456-7890');
        $companyEmail = Settings::get('company.email', 'info@company.com');
        
        $pdf = PDF::loadView("invoices.templates.$template", compact(
            'invoice', 
            'companyName', 
            'companyAddress', 
            'companyPhone', 
            'companyEmail'
        ));
        
        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }
}