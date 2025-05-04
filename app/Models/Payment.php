<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_id',
        'client_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes'
    ];
    
    protected $casts = [
        'payment_date' => 'date',
    ];
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}