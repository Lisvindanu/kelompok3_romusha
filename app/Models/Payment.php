<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'payments';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'amount',
        'canceled_at',
        'confirmed_at',
        'reason',
        'status',
        'purchase_id'
    ];

    // Gunakan tipe data yang sesuai untuk beberapa kolom
    protected $casts = [
        'canceled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    // Relasi dengan Purchase (misalnya: satu pembayaran hanya milik satu pembelian)
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);  // Anda bisa menyesuaikan nama model 'Purchase'
    }

    // Status pembayaran dapat diakses dengan menggunakan accessor
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Membuat status pembayaran dengan huruf pertama kapital
    }
}
