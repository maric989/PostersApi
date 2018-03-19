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

    public function index()
    {
        $post = Post::all();

        return fractal()
            ->collection($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function destroy(PostDeleteRequest $request)
    {
        $id = $request->id;

        $post = Post::find($id);
        $post->delete();

        return response()->json('Post is deleted', 200);
    }

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
