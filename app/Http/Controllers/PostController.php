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
        abort_unless(
            auth()->check() && auth()->user()->canEdit(),
            403
        );

        $drafts = Post::draft()
            ->latest()
            ->get();

        $pendingPosts = Post::pending()
            ->latest()
            ->get();

        return view(
            'news.create',
            compact('drafts', 'pendingPosts')
        );
    }

    public function store(Request $request)
    {
        abort_unless(
            auth()->check() && auth()->user()->canEdit(),
            403
        );

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'picture' => 'nullable|file|image',
        ]);

        $picturePath = null;

        if ($request->hasFile('picture')) {
            $picturePath = $request
                ->file('picture')
                ->store('posts', 'public');
        }

        $status = $request->input('action') === 'moderation'
            ? 'pending'
            : 'draft';

        Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'picture' => $picturePath,
            'status' => $status,
            'likes' => 0,
            'comments' => 0,
            'published_at' => null,
        ]);

        return back()->with(
            'success',
            $status === 'pending'
                ? 'Новость отправлена на модерацию!'
                : 'Новость сохранена как черновик!'
        );
    }

    public function edit(Post $post)
    {
        if (!in_array($post->status, ['draft', 'returned'])) {
            return redirect()->route('news.index')->with('error', 'Этот пост нельзя редактировать.');
        }

        return view('news.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'picture' => 'nullable|file|image', 
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
        ];

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('posts', 'public');
        }

        if ($request->input('action') === 'moderation') {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'draft';
        }

        $post->update($data);

        $message = ($data['status'] === 'pending') ? 'Новость отправлена на модерацию!' : 'Изменения сохранены!';

        return redirect()->route('news.create')->with('success', $message);
    }

    public function submit(Post $post)
    {
        abort_unless(
            auth()->check() && auth()->user()->canEdit(),
            403
        );

        $post->update([
            'status' => 'pending'
        ]);

        return back()->with(
            'success',
            'Новость отправлена на модерацию!'
        );
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
            ->with(['user', 'postComments.user'])
            ->orderBy('published_at', 'desc')
            ->get();

        return view('news.index', compact('posts'));
    }

    public function like(Post $post)
    {
        $user = auth()->user();

        if (!$user->canInteract()) {
            abort(403);
        }

        if ($post->isLikedBy($user)) {
            // Если уже лайкнул — убрать лайк
            $post->likesRelation()->detach($user->id);
        } else {
            // Если ещё не лайкнул — добавить лайк
            $post->likesRelation()->attach($user->id);
        }

        return back();
    }


}
