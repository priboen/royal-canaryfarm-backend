<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breeder extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'address',
        'photo',
        'phone'
    ];

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function birdParents(){
        return $this->hasMany(BirdParent::class);
    }
}
