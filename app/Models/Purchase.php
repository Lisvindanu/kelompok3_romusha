<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
