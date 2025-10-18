<?php
/**
 * IDE Helper file for better IntelliSense
 * This file helps IDEs understand the relationships and methods
 */

namespace App\Models {
    /**
     * @method bool isAdmin()
     * @method bool isUser()
     * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany watchlistMovies()
     * @method bool hasInWatchlist(int $movieId)
     */
    class User extends \Illuminate\Foundation\Auth\User {}
}