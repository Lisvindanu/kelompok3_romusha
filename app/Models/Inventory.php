<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Inventory extends Model
{
    // Nama tabel
    protected $table = 'inventory';

    // Menonaktifkan timestamps bawaan Laravel
    public $timestamps = false;

    // Kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'last_updated',
    ];

    // Tipe data kolom
    protected $casts = [
        'last_updated' => 'datetime', // Kolom last_updated diformat sebagai datetime
    ];

    // Relasi dengan model User (jika ada tabel users)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mengambil data produk dari API eksternal
    public function fetchProduct()
    {
        $apiKey = config('services.spring.api_key');
        $baseUrl = config('services.spring.base_url');

        $response = Http::withHeaders([
            'X-Api-Key' => $apiKey
        ])->get("{$baseUrl}/products/{$this->product_id}");

        return $response->successful() ? $response->json() : null;
    }
}
