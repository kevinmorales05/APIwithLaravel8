<?php

namespace Database\Seeders;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciamos la tabla comments
        Comment::truncate();
        $faker = \Faker\Factory::create();
        // Obtenemos todos los artículos de la bdd
        $articles = Article::all();
        // Obtenemos todos los usuarios
        $users = User::all();
        foreach ($users as $user) {
        // iniciamos sesión con cada uno
        JWTAuth::attempt(['email' => $user->email, 'password' => '123123']);
        // Creamos un comentario para cada artículo con este usuario
        foreach ($articles as $article) {
        Comment::create([
        'text' => $faker->paragraph,
        'article_id' => $article->id,
        ]);
        }
        }
    }
}
