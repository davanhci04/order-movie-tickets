<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'score'
    ];

    protected $casts = [
        'score' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    protected static function booted()
    {
        static::saved(function ($rating) {
            $rating->movie->updateAverageRating();
        });

        static::deleted(function ($rating) {
            $rating->movie->updateAverageRating();
        });
    }
}
