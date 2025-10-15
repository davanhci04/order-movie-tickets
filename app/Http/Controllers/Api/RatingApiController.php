<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RatingApiController extends Controller
{
    /**
     * Store or update a rating for a movie.
     */
    public function store(Request $request, Movie $movie): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        try {
            $rating = Rating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'movie_id' => $movie->getKey()
                ],
                [
                    'rating' => $request->input('rating')
                ]
            );

            $rating->load('user');

            // Calculate new average rating
            $averageRating = $movie->ratings()->avg('rating');
            $totalRatings = $movie->ratings()->count();

            return response()->json([
                'success' => true,
                'message' => 'Rating saved successfully',
                'data' => [
                    'rating' => $rating,
                    'movie_stats' => [
                        'average_rating' => round($averageRating, 1),
                        'total_ratings' => $totalRatings
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save rating'
            ], 500);
        }
    }

    /**
     * Get user's rating for a movie.
     */
    public function show(Movie $movie): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $rating = Rating::where('user_id', Auth::id())
            ->where('movie_id', $movie->getKey())
            ->first();

        return response()->json([
            'success' => true,
            'data' => $rating
        ]);
    }

    /**
     * Remove user's rating for a movie.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $deleted = Rating::where('user_id', Auth::id())
            ->where('movie_id', $movie->getKey())
            ->delete();

        if ($deleted) {
            // Calculate new average rating
            $averageRating = $movie->ratings()->avg('rating');
            $totalRatings = $movie->ratings()->count();

            return response()->json([
                'success' => true,
                'message' => 'Rating removed successfully',
                'data' => [
                    'movie_stats' => [
                        'average_rating' => $averageRating ? round($averageRating, 1) : 0,
                        'total_ratings' => $totalRatings
                    ]
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No rating found to remove'
        ], 404);
    }
}