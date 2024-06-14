<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('mybooks', [BookController::class, 'myLibrary'])->name('books.myLibrary')->middleware('auth');
Route::get('', [BookController::class, 'companyLibrary'])->name('books.companyLibrary')->middleware('auth');

Route::post('like', [LikeController::class, 'like'])->middleware('auth');
Route::post('unlike', [LikeController::class, 'unlike'])->middleware('auth');

Route::post('/review', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');  
Route::get('/review/{id}', [ReviewController::class, 'show'])->middleware('auth')->name('reviews.show'); 
Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->middleware('auth')->name('reviews.edit');  
Route::put('/review/{id}', [ReviewController::class, 'update'])->middleware('auth')->name('reviews.update');  
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->middleware('auth')->name('reviews.destroy'); 


Route::get('/aboutus', [AboutController::class, 'index'])->name('home');
