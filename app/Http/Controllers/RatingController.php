<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Store or update a rating.
     */
    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:10'
        ]);

        $userId = Auth::id();
        
        // Check if user already rated this movie
        $existingRating = Rating::where('user_id', $userId)
            ->where('movie_id', $movie->id)
            ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update(['score' => $request->score]);
            $message = 'Rating updated successfully!';
        } else {
            // Create new rating
            Rating::create([
                'user_id' => $userId,
                'movie_id' => $movie->id,
                'score' => $request->score
            ]);
            $message = 'Rating added successfully!';
        }

        return back()->with('success', $message);
    }

    /**
     * Remove the specified rating.
     */
    public function destroy(Movie $movie)
    {
        $userId = Auth::id();
        
        $rating = Rating::where('user_id', $userId)
            ->where('movie_id', $movie->id)
            ->first();

        if ($rating) {
            $rating->delete();
            return back()->with('success', 'Rating removed successfully!');
        }

        return back()->with('error', 'Rating not found!');
    }
}
