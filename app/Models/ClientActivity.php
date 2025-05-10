<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'type',
        'description',
        'subject_id',
        'subject_type',
        'subject_reference',
        'amount'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }
}