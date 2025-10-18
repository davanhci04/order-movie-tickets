<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @property User $user
 */

class WatchlistController extends Controller
{
    /**
     * Display user's watchlist
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        $watchlistMovies = $user->watchlistMovies()
            ->withCount('ratings')
            ->withAvg('ratings', 'score')
            ->orderBy('watchlists.created_at', 'desc')
            ->paginate(12);

        return view('movies.watchlist', compact('watchlistMovies'));
    }

    /**
     * Add movie to watchlist
     */
    public function add(Request $request, Movie $movie)
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Kiểm tra nếu phim đã có trong watchlist
        if ($user->hasInWatchlist($movie->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Phim đã có trong danh sách xem của bạn!'
            ]);
        }

        // Thêm vào watchlist
        Watchlist::create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm phim vào danh sách xem!',
            'inWatchlist' => true
        ]);
    }

    /**
     * Remove movie from watchlist
     */
    public function remove(Request $request, Movie $movie)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $watchlistItem = Watchlist::where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->first();

        if ($watchlistItem) {
            $watchlistItem->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa phim khỏi danh sách xem!',
                'inWatchlist' => false
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Phim không có trong danh sách xem của bạn!'
        ]);
    }

    /**
     * Toggle movie in watchlist (add if not exists, remove if exists)
     */
    public function toggle(Request $request, Movie $movie)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->hasInWatchlist($movie->id)) {
            return $this->remove($request, $movie);
        } else {
            return $this->add($request, $movie);
        }
    }
}
