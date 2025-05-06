<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'quote_number',
        'quote_date',
        'expiry_date',
        'subtotal',
        'gst_amount',
        'total',
        'notes',
        'status', // draft, sent, approved, rejected, canceled
        'terms_and_conditions'
    ];

    protected $casts = [
        'quote_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function calculateTotals()
    {
        $subtotal = $this->items->sum(function($item) {
            return ($item->price / 1.1) * $item->quantity; // Assuming 10% GST
        });

        $this->subtotal = $subtotal;
        $this->gst_amount = $this->items->sum(function($item) {
            return $item->price * $item->quantity - ($item->price / 1.1) * $item->quantity;
        });
        $this->total = $subtotal + $this->gst_amount;

        $this->save();
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function convertToInvoice()
    {
        $invoice = new Invoice([
            'client_id' => $this->client_id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'invoice_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(30),
            'subtotal' => $this->subtotal,
            'gst_amount' => $this->gst_amount,
            'total' => $this->total,
            'notes' => $this->notes,
            'status' => 'draft'
        ]);
        $invoice->save();

        // Copy quote items to invoice items
        foreach ($this->items as $quoteItem) {
            $invoiceItem = new InvoiceItem([
                'product_id' => $quoteItem->product_id,
                'quantity' => $quoteItem->quantity,
                'price' => $quoteItem->price,
                'description' => $quoteItem->description
            ]);

            $invoice->items()->save($invoiceItem);

            // Copy serial numbers if any
            if ($quoteItem->serialNumbers && $quoteItem->serialNumbers->count() > 0) {
                foreach ($quoteItem->serialNumbers as $serialNumber) {
                    $invoiceItem->serialNumbers()->create([
                        'product_id' => $serialNumber->product_id,
                        'serial_number' => $serialNumber->serial_number
                    ]);
                }
            }
        }

        // Update quote status
        $this->status = 'approved';
        $this->save();

        return $invoice;
    }

    private function generateInvoiceNumber()
    {
        $prefix = Settings::get('invoice.prefix', 'INV-');
        $nextNumber = Settings::get('invoice.next_number', 1001);

        // Update next number in settings
        Settings::set('invoice.next_number', $nextNumber + 1);

        return $prefix . $nextNumber;
    }
}
