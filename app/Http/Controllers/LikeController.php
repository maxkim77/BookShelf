<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        if (\Auth::check()) {
            Like::create([
                'user_id' => auth()->user()->id,
                'book_id' => $request->get('params')['book_id'],
            ]);
            return response()->json(true);
        } else {
            return response()->json(['error' => 'Not authorized.'], 403);
        }
    }

    public function unlike(Request $request)
    {
        if (\Auth::check()) {
            $like = Like::where('book_id', $request->get('params')['book_id'])
                ->where('user_id', auth()->user()->id)
                ->first();
            if (isset($like)) {
                $like->delete();
                return response()->json(true);
            }
        } else {
            return response()->json(['error' => 'Not authorized.'], 403);
        }
    }
}
