<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['parent_status'];
    public function pedigree()
    {
        return $this->belongsTo(Pedigree::class, 'ped_id', 'id');
    }
}
