<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $page = 1;
        $limit = 10;

        if ($request->has('page')) {
            $page = $request->input('page');
        }

        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }

        $posts = Post::query()->paginate($limit, ['*'], 'page', $page);

        if ($posts->isEmpty()) {
            return response(null, 204);
        }

        return response($posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws Throwable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user()->id;
        $post->saveOrFail();

        return response(Post::query()->find($post->id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return response($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        if ($request->has('title')) {
            $post->title = $request->input('title');
        }

        if ($request->has('body')) {
            $post->body = $request->input('body');
        }

        $post->update();

        return response(Post::query()->find($post->id), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        return response($post->delete(), 200);
    }
}
