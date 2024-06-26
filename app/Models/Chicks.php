<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chicks extends Model
{
    use HasFactory;
    protected $fillable = [
        'ring_number',
        'photo',
        'date_of_birth',
        'gender',
        'canary_type'
    ];

    public function pedigree()
    {
        return $this->hasMany(Pedigree::class, 'ped_id', 'id');
    }
}
