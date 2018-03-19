<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Requests\Comments\CommentStoreRequest;
use App\Post;
use App\Transformers\CommentTransformer;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Class CommentController
     * @package App\Http\Controllers
     *
     *  @SWG\Definition(
     *     definition="CommentCreate",
     *     required={"body"},
     *     @SWG\Property(property="body", type="string"),
     * )
     *
     */
    protected $fillable = ['body'];


    /**
     * @SWG\Post(
     *   path="/api/post/{id}/comment",
     *   summary="CommentCreate",
     *   @SWG\Parameter(
     *     name="content-type",
     *     in="header",
     *     description="application/x-www-form-urlencoded",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="Accept",
     *     in="header",
     *     description="application/json",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="token",
     *     required=true,
     *     type="string"
     *   ),
     *  @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Body of Comment ",
     *     required=true,
     *     @SWG\Schema(type="string")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=403, description="Unauthorized"),
     *   @SWG\Response(response=404, description="Not Found")
     * )
     *
     */
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
