<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index(Request $request)
    {
        $query = Movie::query();
        $search = $request->get('search');

        // Apply search if provided - search across multiple fields
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('director', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%');
            });
        }
        
        // Handle sorting
        $sort = $request->get('sort', 'created_desc');
        
        switch ($sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'rating_desc':
                $query->withAvg('ratings', 'score')
                      ->orderByDesc('ratings_avg_score')
                      ->orderBy('title', 'asc'); // Secondary sort by title
                break;
            case 'rating_asc':
                $query->withAvg('ratings', 'score')
                      ->orderBy('ratings_avg_score', 'asc')
                      ->orderBy('title', 'asc'); // Secondary sort by title
                break;
            case 'year_desc':
                $query->orderByDesc('release_year')
                      ->orderBy('title', 'asc'); // Secondary sort by title
                break;
            case 'year_asc':
                $query->orderBy('release_year', 'asc')
                      ->orderBy('title', 'asc'); // Secondary sort by title
                break;
            case 'created_desc':
            default:
                $query->orderByDesc('created_at')
                      ->orderBy('title', 'asc'); // Secondary sort by title
                break;
        }
        
        $movies = $query->paginate(12)->appends($request->query());
        
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie)
    {
        $movie->load(['ratings.user', 'comments.user']);
        
        $userRating = null;
        if (Auth::check()) {
            $userRating = $movie->getUserRating(Auth::id());
        }
        
        return view('movies.show', compact('movie', 'userRating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
