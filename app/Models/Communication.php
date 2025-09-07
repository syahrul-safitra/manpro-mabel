<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_product_id',
        'pesan'
    ];

    public function user() {
        return $this->BelongsTo(User::class);
    }

}
