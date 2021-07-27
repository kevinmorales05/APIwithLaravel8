<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;


class ArticleController extends Controller
{
   private static $rules = [
      'title' => 'required|string|unique:articles|max:255',
      'body' => 'required',
      'category_id' => 'required|exists:categories,id'
   ];
   private static $messages = [
      'required' => 'El campo :attribute es obligatorio',
      'body.required' => 'El body no es válido', 
   ];

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
  $request->validate([
   'title'=> 'required|string|unique:articles|max:255',
   'body'=> 'required',
   'category' => 'required|exists:categories,id',
   'image' => 'required|image|dimensions:min_width=200,min_height=200',
], self::$messages
);

   $article = new Article($request->all());
   $path = $request->image->store('public/articles');
   //con esto se genera un nombre aleatorio y se almacena en la carpeta public, para uso publico
   //$path = $request->image->storeAs('public/articles', $request->user()->id .'_' . $article->title . '.' . $request->image->extension());

   $article->image = $path;
   $article->save();

      
      return response()->json(new ArticleResource($article), 201);
 }

 public function update(Request $request, Article $article)
 {
   //$request -> validate(self::$rules, self::$messages); 
   $request->validate([
      'title'=> 'required|string|unique:articles|max:255',
      'body'=> 'required',
      'category_id' => 'required|exists:categories,id'
   ], self::$messages
   );
   
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
