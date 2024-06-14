<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'book_id' => 'required|string',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'thumbnail' => 'nullable|string',
        'authors' => 'nullable|string',
        'categories' => 'nullable|string',
        'review' => 'nullable|string',
        'shared_with' => 'required|array',
        'shared_with.*' => 'in:my_library,company_library',
    ]);

    $shared_with_values = ['my_library'];

    if (in_array('company_library', $validated['shared_with'])) {
        $shared_with_values[] = 'company_library';
    }

    foreach ($shared_with_values as $shared_with) {
        $review = new Review();
        $review->user_id = auth()->id();
        $review->book_id = $validated['book_id'];
        $review->title = $validated['title'];
        $review->description = $validated['description'] !== 'null' ? $validated['description'] : null;
        $review->thumbnail = $validated['thumbnail'];
        $review->authors = $validated['authors'] !== 'null' ? $validated['authors'] : null;
        $review->categories = $validated['categories'] !== 'null' ? $validated['categories'] : null;
        $review->review = $validated['review'] !== 'null' ? $validated['review'] : null;
        $review->shared_with = $shared_with;
        $review->save();
    }

    return redirect()->route('reviews.show', ['id' => $review->id])->with('status', 'Review created successfully!');
}


    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.show', compact('review'));
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'review' => 'nullable|string',
            'shared_with' => 'required|array',
            'shared_with.*' => 'in:my_library, company_library',
        ]);

        $review = Review::findOrFail($id);
        $review->title = $validated['title'];
        $review->description = $validated['description'];
        $review->review = $validated['review'];
        $review->shared_with = implode(',', $validated['shared_with']);
        $review->save();

        return redirect()->route('reviews.show', ['id' => $review-> id])-> with ('status', '성공적으로 처리 되었습니다.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect() -> route('books.myLibrary') -> with('status', '성공적으로 처리 되었습니다.');
    }

}
