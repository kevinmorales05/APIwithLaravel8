<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;


class ArticleController extends Controller
{
 public function index()
 {
    return new ArticleCollection(Article::paginate(10)) ; //cuando son mas objetos, es decir una coleccion
      //response()->json(ArticleResource::collection(Article::all()),200) como json, desaparece data, sin metadatos
   }
 public function show($id)
 {
    return response()->json(new ArticleResource(Article::find($id)),200);
 }
 public function store(Request $request)
 {

   //implementar con validacion

    $article = Article::create($request->all());
    return response()->json($article, 201);
 }

 public function update(Request $request, Article $article)
 {
    $article->update($request->all());
    return response()->json($article, 200);
 }
 public function delete(Request $request, $id)
 {
 $article = Article::findOrFail($id);
 $article->delete();
 return 204;
 }
}
