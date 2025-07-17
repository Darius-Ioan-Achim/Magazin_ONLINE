<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creează 10 categorii cu descriere (implicit)
        Category::factory()->count(10)->create();

        // Creează 3 categorii fără descriere
        Category::factory()->count(3)->withoutDescription()->create();

        // Creează o categorie cu un nume specific
        Category::factory()->withName('Tehnologie și Inovație')->create();
    }
}
