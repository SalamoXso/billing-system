<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'has_serial'];

    public function serialNumbers()
    {
        return $this->hasMany(SerialNumber::class);
    }
}
