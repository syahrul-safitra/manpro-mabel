<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'nama_customer',
        'biaya_pembuatan',
        'ukuran',
        'deskripsi',
        'waktu_mulai',
        'waktu_tenggat',
        'waktu_selesai',
        'desain',
        'progress',
        'gambar_proses',
        'selesai'
    ];

    public function material() {
        return $this->hasMany(Material::class);
    }

    public function worker() {
        return $this->hasMany(Worker::class);
    }

    public function comment() {
        return $this->hasMany(Communication::class);
    }

}
