<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        abort_unless($post->status === 'published', 404);

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => (int) $request->user()->id,
            'body' => $validated['body'],
        ]);

        $post->increment('comments');

        return back()->with('success', 'Комментарий добавлен.');
    }

    public function destroy(Request $request, Post $post, Comment $comment): RedirectResponse
    {
        abort_unless($comment->post_id === $post->id, 404);

        if ($comment->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        $comment->delete();
        $post->decrement('comments');

        return back()->with('success', 'Комментарий удален.');
    }
}
