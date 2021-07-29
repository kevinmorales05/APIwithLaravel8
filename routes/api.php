<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Article;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::get('/articles', [ArticleController::class,'index']);

//Rutas Usuario
Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'authenticate']);
//ruta para conocer la imagen
Route::get('/articles/{article}/image', [ArticleController::class,'image']);
//Proteccion de Rutas
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/user', [UserController::class,'getAuthenticatedUser']);
    //Articles
    Route::get('/articles/{article}', [ArticleController::class,'show']);
    Route::post('/articles', [ArticleController::class,'store']);
    Route::put('/articles/{article}', [ArticleController::class,'update']);
    Route::delete('/articles/{article}', [ArticleController::class,'delete']);
    
    //Comments
    Route::get('/articles/{id}/comments', [CommentController::class,'index']);
    Route::get('/articles/{article}/comments/{comment}', [CommentController::class,'show']);
    Route::post('/articles/{article}/comments', [CommentController::class,'store']);
    Route::put('/articles/{id}.comments/{comment_id}', [CommentController::class,'update']);
    Route::delete('/articles/{id}/comments/{comment_id}', [CommentController::class,'delete']);
 });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
