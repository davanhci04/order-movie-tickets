<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'movie_id' => $movie->id,
            'content' => $request->input('content')
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // Check if the comment belongs to the authenticated user
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $request->input('content')
        ]);

        return back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        // Check if the comment belongs to the authenticated user or user is admin
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
