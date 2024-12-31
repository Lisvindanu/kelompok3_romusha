<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Inventory extends Model
{
    // Define the table name if it's not the plural form of the model name
    protected $table = 'inventories'; // Optional: Laravel will assume the table is 'inventories' if you follow the plural convention

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'last_updated',
    ];

    // Cast 'last_updated' to a date type to ensure it works well with Carbon
    protected $casts = [
        'last_updated' => 'datetime',
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
