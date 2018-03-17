<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Requests\Comments\CommentStoreRequest;
use App\Post;
use App\Transformers\CommentTransformer;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $fillable = ['body'];

    public function store(CommentStoreRequest $request)
    {
        $user = Auth::user();
        $post = Post::find($request->id);

        $comment = new Comments;

        $comment->body = $request->body;
        $comment->post()->associate($post);
        $comment->user()->associate($user);

        $comment->save();

        return fractal()
            ->item($comment)
            ->parseIncludes('user')
            ->transformWith(new CommentTransformer())
            ->toArray();
    }
}
