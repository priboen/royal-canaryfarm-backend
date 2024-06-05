<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'breeder_id',
        'chicks_id',
        'customer',
        'phone',
        'date',
        'price',
        'payment',
        'description'
    ];

    public function transactions()
    {
        return $this->belongsTo(Chicks::class, 'chicks_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Breeder::class, 'breeder_id', 'id');
    }
}
