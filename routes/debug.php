<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;

// Debug watchlist functionality
Route::get('/debug-watchlist', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $user = auth()->user();
    $movies = Movie::take(3)->get();
    
    $debug = [
        'user_id' => $user->id,
        'user_email' => $user->email,
        'total_movies' => Movie::count(),
        'user_watchlist_count' => $user->watchlist()->count(),
        'movies_check' => []
    ];
    
    foreach ($movies as $movie) {
        $debug['movies_check'][] = [
            'movie_id' => $movie->id,
            'title' => $movie->title,
            'in_watchlist' => $user->hasInWatchlist($movie->id),
            'watchlist_records' => Watchlist::where('user_id', $user->id)->where('movie_id', $movie->id)->count()
        ];
    }
    
    return response()->json($debug);
});

Route::post('/debug-toggle-watchlist/{movieId}', function($movieId) {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $user = auth()->user();
    $movie = Movie::find($movieId);
    
    if (!$movie) {
        return response()->json(['error' => 'Movie not found']);
    }
    
    $isInWatchlist = $user->hasInWatchlist($movieId);
    
    if ($isInWatchlist) {
        // Remove from watchlist
        Watchlist::where('user_id', $user->id)->where('movie_id', $movieId)->delete();
        $message = 'Removed from watchlist';
        $newState = false;
    } else {
        // Add to watchlist
        Watchlist::create(['user_id' => $user->id, 'movie_id' => $movieId]);
        $message = 'Added to watchlist';
        $newState = true;
    }
    
    return response()->json([
        'success' => true,
        'message' => $message,
        'inWatchlist' => $newState,
        'movie_title' => $movie->title
    ]);
});