<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $posts = Post::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->get();

        return response()->json($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'picture' => 'nullable|file|image', 
        ]);

        $post = Post::create(array_merge($validated, [
            'status' => 'draft', 
            'likes' => 0,
            'comments' => 0,
            'published_at' => null,
        ]));

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::where('id', $id)
                    ->where('status', 'published')
                    ->firstOrFail();

        return response()->json($post);
    }

    public function newsPage()
    {
        // Получаем все опубликованные новости
        $posts = Post::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->get();

        return view('news.index', compact('posts'));
    }


}
