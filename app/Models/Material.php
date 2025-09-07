<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumlah', 
        'order_product_id', 
        'item_id'
    ];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
