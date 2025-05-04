<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['invoice', 'client']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('invoice', function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%");
            });
        }
        
        $payments = $query->latest()->paginate(10);
        
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $clients = Client::all();
        $invoices = Invoice::whereRaw('total > (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE invoice_id = invoices.id)')->get();
        
        return view('payments.create', compact('clients', 'invoices'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $invoice = Invoice::findOrFail($validated['invoice_id']);
        
        $payment = new Payment();
        $payment->invoice_id = $validated['invoice_id'];
        $payment->client_id = $invoice->client_id;
        $payment->amount = $validated['amount'];
        $payment->payment_date = $validated['payment_date'];
        $payment->payment_method = $validated['payment_method'];
        $payment->notes = $validated['notes'] ?? null;
        $payment->save();
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'client']);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment)
    {
        $clients = Client::all();
        $invoices = Invoice::whereRaw('total > (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE invoice_id = invoices.id AND id != ?)', [$payment->id])
            ->orWhere('id', $payment->invoice_id)
            ->get();
        
        return view('payments.edit', compact('payment', 'clients', 'invoices'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $invoice = Invoice::findOrFail($validated['invoice_id']);
        
        $payment->invoice_id = $validated['invoice_id'];
        $payment->client_id = $invoice->client_id;
        $payment->amount = $validated['amount'];
        $payment->payment_date = $validated['payment_date'];
        $payment->payment_method = $validated['payment_method'];
        $payment->notes = $validated['notes'] ?? null;
        $payment->save();
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}