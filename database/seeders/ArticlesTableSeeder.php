<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
    // Vaciar la tabla.
    Article::truncate();
    $faker = \Faker\Factory::create();
    // Crear artículos ficticios en la tabla
        for ($i = 0; $i < 50; $i++) {
        Article::create([
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        ]);
        }
    }
}
