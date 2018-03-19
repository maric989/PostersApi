<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\GetSinglePostRequest;
use App\Http\Requests\Post\PostDeleteRequest;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Post;
use App\Transformers\PostTransformer;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;


class PostController extends Controller
{
    /**
     * Class PostController
     * @package App\Http\Controllers
     *
     * @SWG\Definition(
     *     definition="PostUpdate",
     *     required={"body","id"},
     *     @SWG\Property(property="body", type="string"),
     * ),
     * @SWG\Definition(
     *     definition="PostsIndex",
     * ),
     * @SWG\Definition(
     *     definition="PostDelete",
     *     required={"id"},
     *     @SWG\Property(property="id", type="integer")
     * )
     *  @SWG\Definition(
     *     definition="SinglePost",
     *     required={"id"},
     *     @SWG\Property(property="id", type="integer")
     * )
     *  @SWG\Definition(
     *     definition="PostCreate",
     *     required={"body","title"},
     *     @SWG\Property(property="body", type="string"),
     *     @SWG\Property(property="title", type="string")
     * )
     *
     */

    /**
     * @SWG\Post(
     *   path="/api/post",
     *   summary="PostCreate",
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
     *     name="title",
     *     in="body",
     *     description="Title of post",
     *     required=true,
     *     type="string",
     *     @SWG\Schema(type="string")
     *   ),
     *  @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Body of Post ",
     *     required=true,
     *     @SWG\Schema(type="string")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=403, description="Unauthorized"),
     *   @SWG\Response(response=404, description="Not Found")
     * )
     *
     */
    public function store(PostStoreRequest $request)
    {
        $post = new Post;

        $user = Auth::user();

        $post->title = $request->title;
        $post->body  = $request->body;
        $post->user()->associate($user);

        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    /**
     * @SWG\Get(
     *   path="/api/post",
     *   summary="PostsIndex",
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
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function index()
    {
        $post = Post::all();

        return fractal()
            ->collection($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    /**
     * @SWG\Delete(
     *   path="/api/post/{id}",
     *   summary="Delete Post",
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
     *     name="ID",
     *     in="query",
     *     description="Post ID for delete",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=403, description="Unauthorized"),
     *   @SWG\Response(response=404, description="Not Found")
     * )
     *
     */
    public function destroy(PostDeleteRequest $request)
    {
        $id = $request->id;

        $post = Post::find($id);
        $post->delete();

        return response()->json('Post is deleted', 200);
    }

    /**
     * @SWG\Patch(
     *   path="/api/post/{id}",
     *   summary="PostUpdate",
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
     *     name="ID",
     *     in="query",
     *     description="Post ID for update",
     *     required=true,
     *     type="integer"
     *   ),
     *  @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Body text for update",
     *     required=true,
     *     @SWG\Schema(type="string")
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=403, description="Unauthorized"),
     *   @SWG\Response(response=404, description="Not Found")
     * )
     *
     */
    public function update(PostUpdateRequest $request,Post $post)
    {
        $post = $post->find($request->id);

        if ($post->user_id != Auth::user()->id)
        {
            throw new AccessDeniedException();
        }

        $post->body = $request->body??$post->body;

        $post->save();

        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    /**
     * @SWG\Get(
     *   path="/api/post/{id}",
     *   summary="SinglePost",
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
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="token",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function show(GetSinglePostRequest $request,Post $post)
    {
        $post = $post->find($request->id);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->parseIncludes(['comments'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }
}
