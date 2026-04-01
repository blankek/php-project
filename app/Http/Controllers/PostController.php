<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index() 
    {
        $posts = Post::where('status', 'published')
                    ->orderBy('published_at', 'desc')
                    ->get();

        return response()->json($posts);
    }

    public function create()
    {
        $drafts = Post::draft()->latest()->get();
        return view('news.create', compact('drafts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'picture' => 'nullable|file|image', 
        ]);

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('posts', 'public');
        }

        $status = $request->has('submit_moderation') ? 'pending' : 'draft';

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'picture' => $picturePath,
            'status' => 'draft', 
            'likes' => 0,
            'comments' => 0,
            'published_at' => null,
        ]);

         $message = $status === 'pending' ? 'Новость отправлена на модерацию!' : 'Новость сохранена как черновик!';

        return back()->with('success', $message);
    }

    public function submit(Post $post)
    {
        $post->update(['status' => 'pending']);

        return back()->with('success', 'Новость отправлена на модерацию!');
    }

    public function show($id)
    {
        $post = Post::where('id', $id)
                    ->where('status', 'published')
                    ->firstOrFail();

        return response()->json($post);
    }

    public function newsPage()
    {
        $posts = Post::published()
            ->with(['postComments.user'])
            ->orderBy('published_at', 'desc')
            ->get();

        return view('news.index', compact('posts'));
    }


}
