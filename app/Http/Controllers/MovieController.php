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
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(12);
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
