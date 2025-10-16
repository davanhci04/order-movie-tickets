<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistManagementController extends Controller
{
    /**
     * Display watchlist by users (main function)
     */
    public function byUser()
    {
        $users = User::withCount('watchlist')
            ->having('watchlist_count', '>', 0)
            ->orderBy('watchlist_count', 'desc')
            ->paginate(20);

        return view('admin.watchlists.by-user', compact('users'));
    }

    /**
     * Remove item from any user's watchlist
     */
    public function removeItem(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'movie_id' => 'required|exists:movies,id',
        ]);

        $watchlistItem = Watchlist::where('user_id', $request->user_id)
            ->where('movie_id', $request->movie_id)
            ->first();

        if ($watchlistItem) {
            $watchlistItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa phim khỏi watchlist của người dùng!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy item trong watchlist!'
        ]);
    }
}
