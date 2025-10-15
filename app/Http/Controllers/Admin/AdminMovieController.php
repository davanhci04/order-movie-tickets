<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_url' => 'nullable|url',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'director' => 'nullable|string|max:255',
        ]);

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie created successfully!');
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_url' => 'nullable|url',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'director' => 'nullable|string|max:255',
        ]);

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully!');
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted successfully!');
    }
}
