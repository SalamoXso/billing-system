<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_id', 
        'invoice_number', 
        'invoice_date', 
        'due_date', 
        'subtotal',
        'gst_amount', 
        'total', 
        'notes'
    ];
    
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
    ];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    
    /**
     * Calculate the invoice totals based on items
     * Prices are entered including GST, but subtotal should be ex GST
     */
    public function payments()
{
    return $this->hasMany(Payment::class);
}
    public function getBalanceAttribute()
{
    return $this->total - $this->payments()->sum('amount');
}
    public function calculateTotals()
    {
        // Get GST rate from settings (default to 10%)
        $gstRate = Settings::get('gst_rate', 0.10);
        
        // Calculate subtotal (ex GST) and GST amount
        $subtotal = 0;
        $gstAmount = 0;
        
        foreach ($this->items as $item) {
            // Calculate price excluding GST
            $priceExGst = $item->price / (1 + $gstRate);
            $itemSubtotal = $priceExGst * $item->quantity;
            $itemGst = ($item->price - $priceExGst) * $item->quantity;
            
            $subtotal += $itemSubtotal;
            $gstAmount += $itemGst;
        }
        
        // Update the invoice
        $this->subtotal = round($subtotal, 2);
        $this->gst_amount = round($gstAmount, 2);
        $this->total = round($subtotal + $gstAmount, 2);
        $this->save();
    }
}