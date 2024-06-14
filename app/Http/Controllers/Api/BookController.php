<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Books;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword') ?? 'php';
        $API_KEY = env('GOOGLE_BOOKS_KEY');

        $client = new Google_Client();
        $client->setApplicationName("BookTrunk");
        $client->setDeveloperKey($API_KEY);

        $service = new Google_Service_Books($client);
        $optParams = [];

        $books = $service->volumes->listVolumes($keyword, $optParams);

        $data = [];
        foreach ($books as $book) {
            $data['data'][] = [
                'id' => $book['id'],
                'title' => $book['volumeInfo']['title'],
                'description' => $book['volumeInfo']['description'],
                'thumbnail' => $book['volumeInfo']['imageLinks']['thumbnail'] ?? null,
                'medium' => $book['volumeInfo']['imageLinks']['medium'] ?? null,
                'authors' => $book['volumeInfo']['authors'] ?? [],
                'categories' => $book['volumeInfo']['categories'] ?? []
            ];
        }
        return response()->json($data);
    }

    public function show(Request $request, string $id)
    {
        $API_KEY = env('GOOGLE_BOOKS_KEY');

        $client = new Google_Client();
        $client->setApplicationName("BookTrunk");
        $client->setDeveloperKey($API_KEY);

        $service = new Google_Service_Books($client);

        $book = $service->volumes->get($id);

        $data = [
            'id' => $book['id'],
            'title' => $book['volumeInfo']['title'],
            'description' => $book['volumeInfo']['description'],
            'thumbnail' => $book['volumeInfo']['imageLinks']['thumbnail'] ?? null,
            'medium' => $book['volumeInfo']['imageLinks']['medium'] ?? null,
            'authors' => $book['volumeInfo']['authors'] ?? [],
            'categories' => $book['volumeInfo']['categories'] ?? []
        ];

        return response()->json($data);
    }
}
