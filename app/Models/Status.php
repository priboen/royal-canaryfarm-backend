<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['parent_id', 'parent_status'];

    public function parent()
    {
        return $this->belongsTo(BirdParent::class, 'parent_id', 'id');
    }

    public function relation()
    {
        return $this->belongsTo(ParentChild::class, 'relations_id', 'id');
    }

}
