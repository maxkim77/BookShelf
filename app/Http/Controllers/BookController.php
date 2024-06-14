<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\View\View;

class BookController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(): View
    {
        return view('books.index');
    }

    public function myLibrary(): View
    {
        $my_books = Review::where('user_id', auth()->id())
            ->where('shared_with', 'my_library')
            ->get();
        return view('books.mybooks', compact('my_books'));
    }

    public function companyLibrary(): View
    {   
        $user = auth()->user();
        $company_books = Review::where('shared_with', 'company_library')
        ->whereHas('user', function ($query) use ($user) {
            $query->where('company', $user-> company);
        })->get();
        return view('books.companybooks', compact('company_books'));
    }

    public function show(Request $request, string $id): View
    {
        $review = Review::findOrFail($id);
        $book = $review->book();

        return view('reviews.show', compact('review', 'book'));
    }
}
