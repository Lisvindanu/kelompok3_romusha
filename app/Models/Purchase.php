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

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Custom method to fetch product data from the external API
    public function fetchProduct()
    {
        // Example API call to fetch product details by product_id
        $response = Http::get('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/' . $this->product_id);

        if ($response->successful()) {
            return $response->json();
        }

        // Handle error in fetching the product
        return null;
    }
}
