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

    public function getProductShow($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get("{$this->springBootApiUrl}/{$id}");

            if ($response->successful()) {
                $product = $response->json()['data'];
                return view('detail-product', compact('product'));
            }

            return redirect()->route('home')->with('error', 'Failed to retrieve product');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Internal server error: ' . $e->getMessage());
        }
    }

    public function getGameProducts()
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Filter produk berdasarkan kategori "Game"
                $gameProducts = array_filter($products, function ($product) {
                    return strtolower($product['categoryName']) === 'game';
                });

                return view('games', ['products' => $gameProducts]);
            }

            return view('home', [
                'products' => [],
                'error' => $response->json()['message'] ?? 'Failed to retrieve game products'
            ]);
        } catch (\Exception $e) {
            return view('home', [
                'products' => [],
                'error' => 'Internal server error: ' . $e->getMessage()
            ]);
        }
    }

    public function getConsoleProducts()
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Filter produk berdasarkan kategori "Console"
                $consoleProducts = array_filter($products, function ($product) {
                    return strtolower($product['categoryName']) === 'console';
                });

                return view('consoles', ['products' => $consoleProducts]);
            }

            return view('home', [
                'products' => [],
                'error' => $response->json()['message'] ?? 'Failed to retrieve console products'
            ]);
        } catch (\Exception $e) {
            return view('home', [
                'products' => [],
                'error' => 'Internal server error: ' . $e->getMessage()
            ]);
        }
    }
}
