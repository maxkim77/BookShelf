<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Google_Client;
use Google_Service_Books;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'title', 'description', 'thumbnail', 'review', 'shared_with',
    ];

    // Review 모델은 User 모델과 관계가 있습니다.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Review 모델은 Like 모델과 관계가 있습니다.
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function book()
    {
        // Google Books API를 통해 책 정보를 가져옵니다.
        $API_KEY = env('GOOGLE_BOOKS_KEY');

        $client = new Google_Client();
        $client->setApplicationName("BookTrunk");
        $client->setDeveloperKey($API_KEY);

        $service = new Google_Service_Books($client);
        $book_api = $service->volumes->get($this->book_id, []);

        return [
            'id' => $book_api['id'],
            'title' => $book_api['volumeInfo']['title'],
            'description' => $book_api['volumeInfo']['description'],
            'thumbnail' => $book_api['volumeInfo']['imageLinks']['thumbnail'] ?? null,
            'authors' => $book_api['volumeInfo']['authors'] ?? [],
            'categories' => $book_api['volumeInfo']['categories'] ?? [],
            'published_at' => $book_api['volumeInfo']['publishedDate'] ?? null,
        ];
    }
}
