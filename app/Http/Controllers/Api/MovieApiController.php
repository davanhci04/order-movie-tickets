<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieApiController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $movies = Movie::with(['ratings', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $movies->items(),
            'pagination' => [
                'current_page' => $movies->currentPage(),
                'last_page' => $movies->lastPage(),
                'per_page' => $movies->perPage(),
                'total' => $movies->total(),
            ]
        ]);
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie): JsonResponse
    {
        $movie->load(['ratings.user', 'comments.user']);
        
        return response()->json([
            'success' => true,
            'data' => $movie
        ]);
    }

    /**
     * Search movies by title.
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required'
            ], 400);
        }

        $movies = Movie::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $movies
        ]);
    }

    /**
     * Get popular movies.
     */
    public function popular(): JsonResponse
    {
        $movies = Movie::withCount('ratings')
            ->having('ratings_count', '>', 0)
            ->orderBy('ratings_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $movies
        ]);
    }
}