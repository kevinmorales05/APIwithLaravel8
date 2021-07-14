<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Article;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

Route::get('/articles', [ArticleController::class,'index']);

//Rutas Usuario
Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'authenticate']);
//Proteccion de Rutas
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/user', [UserController::class,'getAuthenticatedUser']);
    Route::get('/articles/{id}', [ArticleController::class,'show']);
    Route::post('/articles', [ArticleController::class,'store']);
    Route::put('/articles/{article}', [ArticleController::class,'update']);
    Route::delete('/articles/{article}', [ArticleController::class,'delete']);
 });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
