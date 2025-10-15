<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class RatingCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $movies = Movie::all();

        // Tạo một số user thêm
        $additionalUsers = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($additionalUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Lấy lại danh sách users sau khi tạo thêm
        $allUsers = User::where('role', 'user')->get();

        // Mảng các comment mẫu
        $sampleComments = [
            'Absolutely amazing movie! One of the best I\'ve ever seen.',
            'Great acting and storyline. Highly recommended!',
            'A masterpiece of cinema. Every scene is perfect.',
            'Incredible direction and cinematography.',
            'This movie changed my perspective on life.',
            'Outstanding performances by all actors.',
            'A timeless classic that never gets old.',
            'Brilliant screenplay and excellent execution.',
            'Mind-blowing visual effects and sound design.',
            'Emotionally powerful and deeply moving.',
            'Perfect blend of action and drama.',
            'One of the most influential films ever made.',
            'Exceptional storytelling at its finest.',
            'A true work of art in every aspect.',
            'Unforgettable characters and memorable quotes.',
            'Stunning cinematography and perfect pacing.',
            'This film deserves all the praise it gets.',
            'A movie that stays with you long after watching.',
            'Incredible attention to detail in every scene.',
            'A perfect example of brilliant filmmaking.'
        ];

        // Tạo ratings và comments cho mỗi phim
        foreach ($movies as $movie) {
            // Tạo ratings cho mỗi phim, số lượng không vượt quá số users
            $maxRatings = min(count($allUsers), 6);
            $numRatings = rand(3, $maxRatings);
            $randomUsers = $allUsers->random($numRatings);
            
            foreach ($randomUsers as $user) {
                // Tạo rating từ 7-10 để phù hợp với chất lượng phim
                $rating = rand(7, 10);
                
                Rating::create([
                    'user_id' => $user->id,
                    'movie_id' => $movie->id,
                    'score' => $rating,
                ]);

                // 70% chance tạo comment cho rating này
                if (rand(1, 10) <= 7) {
                    Comment::create([
                        'user_id' => $user->id,
                        'movie_id' => $movie->id,
                        'content' => $sampleComments[array_rand($sampleComments)],
                    ]);
                }
            }
        }

        // Cập nhật average_rating cho các phim
        foreach ($movies as $movie) {
            $avgRating = $movie->ratings()->avg('score');
            if ($avgRating) {
                $movie->update(['average_rating' => round($avgRating, 1)]);
            }
        }
    }
}