<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id', 'child_id', 'relations_id'];

    public function parent()
    {
        return $this->belongsToMany(BirdParent::class, 'parent_id', 'id');
    }

    public function child()
    {
        return $this->belongsToMany(Chicks::class, 'chicks_id', 'id');
    }

    public function status()
    {
        return $this->belongsToMany(Status::class, 'relations_id', 'id');
    }

    protected $table = 'pedigrees';
    protected $hidden = [
        'chicks_id',
    ];
}
