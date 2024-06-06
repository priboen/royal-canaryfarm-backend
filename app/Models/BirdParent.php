<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirdParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'breeder_id',
        'ring_number',
        'photo',
        'date_of_birth',
        'gender',
        'canary_type',
        'type_description'];

    public function breeder()
    {
        return $this->belongsTo(Breeder::class, 'breeder_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'parent_id', 'id');
    }
}
