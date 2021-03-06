<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class NewComment extends Mailable
{
    use Queueable, SerializesModels;
    public $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
   
   // public function build()
   // {
   //     return $this->view('emails.comments.new');
   // }
    public function build()
    {
        return $this->markdown('emails.comments.new')->attach('storage/archivo.pdf', [ //uso markdowwn en vez de view para usar markdowns en vez de html
        'as' => 'name.pdf',
        'mime' => 'application/pdf',
        ]);
      
    }

}
