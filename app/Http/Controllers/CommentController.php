<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Models\Article;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewComment;


class CommentController extends Controller
{
    
    public function index($id)
    {
        
        return response()-> json(CommentResource::collection(Article::find($id)-> comments),200);
    }

    public function show(Article $article, Comment $comment)
    {
        $comment = $article-> comments()-> where('id', $comment->id)->firstOrFail();
        return response()-> json( $comment, 200);
    }


    public function store(Request $request, Article $article)
    {
        $request->validate(
            [
                'text' => 'required|string'
            ]
        );
        $comment= $article->comments()->save(new Comment($request->all()));
        Mail::to($article->user)->send(new NewComment($comment));
        return response()->json(new CommentResource($comment), 201);
    }

  
    

    

   
    public function update(Request $request, Comment $comment)
    {
        //
    }

    
    public function delete(Comment $comment)
    {
        //
    }
}
