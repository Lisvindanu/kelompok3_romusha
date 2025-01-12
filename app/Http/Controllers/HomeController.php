<?php
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;
//
//class HomeController extends Controller
//{
//    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';
//
//    private function extractYoutubeId($url) {
//        if (empty($url)) return null;
//        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
//        return isset($match[1]) ? $match[1] : null;
//    }
//    public function index()
//    {
//        try {
//            // Ambil data dari API
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->get($this->springBootApiUrl);
//
//            if ($response->successful()) {
//                $products = $response->json()['data'];
//
//                // Kelompokkan produk berdasarkan kategori
//                $groupedProducts = [];
//                foreach ($products as $product) {
//                    $groupedProducts[$product['categoryName']][] = $product;
//                }
//                // dd($groupedProducts);
//
//                return view('home', [
//                    'groupedProducts' => $groupedProducts
//                ]);
//            }
//
//            // Jika gagal, tampilkan error
//            return view('home', [
//                'groupedProducts' => [],
//                'error' => $response->json()['message'] ?? 'Failed to retrieve products'
//            ]);
//
//        } catch (\Exception $e) {
//            return view('home', [
//                'groupedProducts' => [],
//                'error' => 'Internal server error: ' . $e->getMessage()
//            ]);
//        }
//    }
//
//    public function getProductShow($id)
//    {
//        try {
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->get("{$this->springBootApiUrl}/{$id}");
//
//            if ($response->successful()) {
//                $product = $response->json()['data'];
//                return view('detail-product', compact('product'));
//            }
//
//            return redirect()->route('home')->with('error', 'Failed to retrieve product');
//        } catch (\Exception $e) {
//            return redirect()->route('home')->with('error', 'Internal server error: ' . $e->getMessage());
//        }
//    }
//
//    public function getGameProducts()
//    {
//        try {
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->get($this->springBootApiUrl);
//
//            if ($response->successful()) {
//                $products = $response->json()['data'];
//
//                // Filter produk berdasarkan kategori "Game"
//                $gameProducts = array_filter($products, function ($product) {
//                    return strtolower($product['categoryName']) === 'game';
//                });
//
//                return view('games', ['products' => $gameProducts]);
//            }
//
//            return view('home', [
//                'products' => [],
//                'error' => $response->json()['message'] ?? 'Failed to retrieve game products'
//            ]);
//        } catch (\Exception $e) {
//            return view('home', [
//                'products' => [],
//                'error' => 'Internal server error: ' . $e->getMessage()
//            ]);
//        }
//    }
//
//    public function getConsoleProducts()
//    {
//        try {
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->get($this->springBootApiUrl);
//
//            if ($response->successful()) {
//                $products = $response->json()['data'];
//
//                // Filter produk berdasarkan kategori "Console"
//                $consoleProducts = array_filter($products, function ($product) {
//                    return strtolower($product['categoryName']) === 'console';
//                });
//
//                return view('consoles', ['products' => $consoleProducts]);
//            }
//
//            return view('home', [
//                'products' => [],
//                'error' => $response->json()['message'] ?? 'Failed to retrieve console products'
//            ]);
//        } catch (\Exception $e) {
//            return view('home', [
//                'products' => [],
//                'error' => 'Internal server error: ' . $e->getMessage()
//            ]);
//        }
//    }
//
//    public function getEVoucherProducts()
//    {
//        try {
//            $response = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json'
//            ])->get($this->springBootApiUrl);
//
//            if ($response->successful()) {
//                $products = $response->json()['data'];
//
//                // Filter produk berdasarkan kategori "E-Voucher"
//                $eVoucherProducts = array_filter($products, function ($product) {
//                    return strtolower($product['categoryName']) === 'e-voucher';
//                });
//
//                return view('ewallet', ['products' => $eVoucherProducts]);
//            }
//
//            return view('home', [
//                'products' => [],
//                'error' => $response->json()['message'] ?? 'Failed to retrieve E-Voucher products'
//            ]);
//        } catch (\Exception $e) {
//            return view('home', [
//                'products' => [],
//                'error' => 'Internal server error: ' . $e->getMessage()
//            ]);
//        }
//    }
//}


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $springBootApiUrl = 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products';

    private function extractYoutubeId($url)
    {
        if (empty($url)) return null;
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return isset($match[1]) ? $match[1] : null;
    }

    public function index()
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Process YouTube URLs for all products
                foreach ($products as &$product) {
                    if (!empty($product['youtubeUrl'])) {
                        $product['youtubeId'] = $this->extractYoutubeId($product['youtubeUrl']);
                    }
                }

                // Group products by category
                $groupedProducts = [];
                foreach ($products as $product) {
                    $groupedProducts[$product['categoryName']][] = $product;
                }

                return view('home', [
                    'groupedProducts' => $groupedProducts
                ]);
            }

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

                // Add YouTube ID to product data
                if (!empty($product['youtubeUrl'])) {
                    $product['youtubeId'] = $this->extractYoutubeId($product['youtubeUrl']);
                }

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

                // Process YouTube URLs for game products
                foreach ($products as &$product) {
                    if (!empty($product['youtubeUrl'])) {
                        $product['youtubeId'] = $this->extractYoutubeId($product['youtubeUrl']);
                    }
                }

                // Filter products by Game category
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

                // Process YouTube URLs for console products
                foreach ($products as &$product) {
                    if (!empty($product['youtubeUrl'])) {
                        $product['youtubeId'] = $this->extractYoutubeId($product['youtubeUrl']);
                    }
                }

                // Filter products by Console category
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

    public function getEVoucherProducts()
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => 'secret',
                'Accept' => 'application/json'
            ])->get($this->springBootApiUrl);

            if ($response->successful()) {
                $products = $response->json()['data'];

                // Process YouTube URLs for e-voucher products
                foreach ($products as &$product) {
                    if (!empty($product['youtubeUrl'])) {
                        $product['youtubeId'] = $this->extractYoutubeId($product['youtubeUrl']);
                    }
                }

                // Filter products by E-Voucher category
                $eVoucherProducts = array_filter($products, function ($product) {
                    return strtolower($product['categoryName']) === 'e-voucher';
                });

                return view('ewallet', ['products' => $eVoucherProducts]);
            }

            return view('home', [
                'products' => [],
                'error' => $response->json()['message'] ?? 'Failed to retrieve E-Voucher products'
            ]);
        } catch (\Exception $e) {
            return view('home', [
                'products' => [],
                'error' => 'Internal server error: ' . $e->getMessage()
            ]);
        }
    }
}
