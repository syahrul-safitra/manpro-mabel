<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_barang',
        'tanggal_keluar',
        'jumlah',
    ];

    public function item() {
        return $this->belongsTo(Item::class, 'nama_barang', 'nama');
    }
}
