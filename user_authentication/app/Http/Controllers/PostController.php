<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        if (!User::find($user_id)) {
            return response()->json(['error' => 'user not found'], 404);
        };
        
        $posts = Post::where('user_id', $user_id)->get();

        if (!$posts) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json([
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$user_id)
    {
        if (!User::find($user_id)) {
            return response()->json(['error' => 'user not found'], 404);
        };

        $user = User::find($user_id);

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $posts = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user_id
        ]);

        $user_post = $user->$posts;

        return response()->json(['success' => 'Post created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id, $id)
    {
        $post = Post::where('id', $id)->where('user_id', $user_id)->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $post = Post::where('id', $id)->where('user_id', $user_id)->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = $user_id;
            $post->save();

        return response()->json(['success' => 'Post updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $id)
    {
        $post = Post::where('id', $id)->where('user_id', $user_id)->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['success' => 'Post deleted successfully'], 200);
    }
}
