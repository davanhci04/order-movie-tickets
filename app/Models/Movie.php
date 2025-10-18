<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'cloudinary_public_id',
        'release_year',
        'genre',
        'duration',
        'director',
        'average_rating'
    ];

    protected $casts = [
        'release_year' => 'integer',
        'duration' => 'integer',
        'average_rating' => 'decimal:2'
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function updateAverageRating()
    {
        $averageRating = $this->ratings()->avg('score') ?: 0;
        $this->update(['average_rating' => round($averageRating, 2)]);
    }

    public function getUserRating($userId)
    {
        return $this->ratings()->where('user_id', $userId)->first();
    }

    /**
     * Watchlist entries for this movie
     */
    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    /**
     * Users who added this movie to watchlist
     */
    public function watchlistUsers()
    {
        return $this->belongsToMany(User::class, 'watchlists');
    }
}
