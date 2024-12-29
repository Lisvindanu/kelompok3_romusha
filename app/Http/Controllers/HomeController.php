<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    public function index()
    {
        try {
            // Ambil data dari API
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret', 
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl);
           
            if ($response->successful()) {
                $products = $response->json()['data'];

                // Kelompokkan produk berdasarkan kategori
                $groupedProducts = [];
                foreach ($products as $product) {
                    $groupedProducts[$product['categoryName']][] = $product;
                }
                // dd($groupedProducts);

                return view('home', [
                    'groupedProducts' => $groupedProducts
                ]);
            }

            // Jika gagal, tampilkan error
            return view('home', [
                'groupedProducts' => [],
                'error' => $response->json()['message'] ?? 'Failed to retrieve products'
            ]);

        } catch (\Exception $e) {
            return view('home', [
                'groupedProducts' => [],
                'error' => 'Internal server error: ' . $e->getMessage()
            ]);
        }
    }

  

}
