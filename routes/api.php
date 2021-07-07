<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\Article;

use App\Http\Controllers\ArticleController;

Route::get('/articles', [ArticleController::class,'index']);
Route::get('/articles/{article}', [ArticleController::class,'show']);
Route::post('/articles', [ArticleController::class,'store']);
Route::put('/articles/{article}', [ArticleController::class,'update']);
Route::delete('/articles/{article}', [ArticleController::class,'delete']);



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
