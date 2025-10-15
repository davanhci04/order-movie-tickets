<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'title' => 'The Shawshank Redemption',
                'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNDE3ODcxYzMtY2YzZC00NmNlLWJiNDMtZDViZWM2MzIxZDYwXkEyXkFqcGdeQXVyNjAwNDUxODI@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 1994,
                'genre' => 'Drama',
                'duration' => 142,
                'director' => 'Frank Darabont',
                'average_rating' => 9.3,
            ],
            [
                'title' => 'The Godfather',
                'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 1972,
                'genre' => 'Crime, Drama',
                'duration' => 175,
                'director' => 'Francis Ford Coppola',
                'average_rating' => 9.2,
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMTMxNTMwODM0NF5BMl5BanBnXkFtZTcwODAyMTk2Mw@@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 2008,
                'genre' => 'Action, Crime, Drama',
                'duration' => 152,
                'director' => 'Christopher Nolan',
                'average_rating' => 9.0,
            ],
            [
                'title' => 'Pulp Fiction',
                'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNGNhMDIzZTUtNTBlZi00MTRlLWFjM2ItYzViMjE3YzI5MjljXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 1994,
                'genre' => 'Crime, Drama',
                'duration' => 154,
                'director' => 'Quentin Tarantino',
                'average_rating' => 8.9,
            ],
            [
                'title' => 'Forrest Gump',
                'description' => 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate and other historical events unfold through the perspective of an Alabama man.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNWIwODRlZTUtY2U3ZS00Yzg1LWJhNzYtMmZiYmEyNmU1NjMzXkEyXkFqcGdeQXVyMTQxNzMzNDI@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 1994,
                'genre' => 'Drama, Romance',
                'duration' => 142,
                'director' => 'Robert Zemeckis',
                'average_rating' => 8.8,
            ],
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into a CEO\'s mind.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 2010,
                'genre' => 'Action, Sci-Fi, Thriller',
                'duration' => 148,
                'director' => 'Christopher Nolan',
                'average_rating' => 8.7,
            ],
            [
                'title' => 'The Matrix',
                'description' => 'A computer programmer discovers that reality as he knows it is a simulation and joins a rebellion to free humanity.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BNzQzOTk3OTAtNDQ0Zi00ZTVkLWI0MTEtMDllZjNkYzNjNTc4L2ltYWdlXkEyXkFqcGdeQXVyNjU0OTQ0OTY@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 1999,
                'genre' => 'Action, Sci-Fi',
                'duration' => 136,
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'average_rating' => 8.7,
            ],
            [
                'title' => 'Interstellar',
                'description' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'poster_url' => 'https://m.media-amazon.com/images/M/MV5BZjdkOTU3MDktN2IxOS00OGEyLWFmMjktY2FiMmZkNWIyODZiXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_FMjpg_UX1000_.jpg',
                'release_year' => 2014,
                'genre' => 'Adventure, Drama, Sci-Fi',
                'duration' => 169,
                'director' => 'Christopher Nolan',
                'average_rating' => 8.6,
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
