<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Horror', 'Thriller',
            'Romance', 'Sci-Fi', 'Fantasy', 'Mystery', 'Crime', 'Documentary',
            'Animation', 'Family', 'Musical', 'Western', 'War', 'Biography',
            'History', 'Sport', 'Music', 'News', 'Reality', 'Talk Show'
        ];

        foreach ($genres as $genre) {
            \App\Models\Genre::factory()->withName($genre)->create();
        }

        // Creează 5 genuri suplimentare complet aleatorii (dacă vrei)
        \App\Models\Genre::factory()->count(5)->random()->create();
    }
    }

