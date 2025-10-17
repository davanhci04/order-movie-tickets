<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Featured Movies (Top 5 rated for carousel)
        $featuredMovies = Movie::where('average_rating', '>', 0)
            ->orderBy('average_rating', 'desc')
            ->take(5)
            ->get();

        // Top Rated Movies (grid display)
        $topRatedMovies = Movie::where('average_rating', '>', 0)
            ->orderBy('average_rating', 'desc')
            ->take(8)
            ->get();

        // Recently Added Movies
        $recentMovies = Movie::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Recommendations based on user ratings (if authenticated)
        $recommendedMovies = collect();
        if (Auth::check()) {
            // Get genres of movies the user has rated highly (4+ stars)
            $userRatedGenres = Movie::join('ratings', 'movies.id', '=', 'ratings.movie_id')
                ->where('ratings.user_id', Auth::id())
                ->where('ratings.score', '>=', 4)
                ->pluck('movies.genre')
                ->unique()
                ->filter();

            if ($userRatedGenres->isNotEmpty()) {
                // Get movies from those genres that user hasn't rated yet
                $ratedMovieIds = Movie::join('ratings', 'movies.id', '=', 'ratings.movie_id')
                    ->where('ratings.user_id', Auth::id())
                    ->pluck('movies.id');

                $recommendedMovies = Movie::whereIn('genre', $userRatedGenres)
                    ->whereNotIn('id', $ratedMovieIds)
                    ->orderBy('average_rating', 'desc')
                    ->take(8)
                    ->get();
            }
        }

        return view('welcome', compact('featuredMovies', 'topRatedMovies', 'recentMovies', 'recommendedMovies'));
    }
}
