<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenreService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('SPRING_API_URL', 'http://virtual-realm-b8a13cc57b6c.herokuapp.com');
        $this->apiKey = env('API_KEY', 'secret');
    }

    public function getAllGenres($page = 0, $size = 10)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey
            ])->get("{$this->baseUrl}/api/genres", [
                'page' => $page,
                'size' => $size
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch genres', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception while fetching genres', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function addGenre($data)
    {
        try {
            // Build URL with query parameters
            $url = "{$this->baseUrl}/api/genres?" . http_build_query([
                    'name' => $data['name'],
                    'categoryId' => $data['categoryId']
                ]);

            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey
            ])->post($url);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to add genre', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception while adding genre', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function updateGenre($id, $data)
    {
        try {
            // Build query parameters for the PUT request
            $queryParams = http_build_query([
                'name' => $data['name'],
                'categoryId' => $data['categoryId']
            ]);

            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey
            ])->put("{$this->baseUrl}/api/genres/{$id}?{$queryParams}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to update genre', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Exception while updating genre', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function deleteGenre($id)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey
            ])->delete("{$this->baseUrl}/api/genres/{$id}");

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('Exception while deleting genre', [
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }
}
