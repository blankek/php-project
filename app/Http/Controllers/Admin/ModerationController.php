<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ModerationController extends Controller{
    public function index(){
        $posts = Post::pending()->latest()->paginate(10);
        return view('admin.moderation.index', compact('posts'));
    }

    public function approve(Post $post){
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Новость опубликована');
    }

    public function reject(Post $post){
        $post->update([
            'status' => 'rejected',
        ]);

        return back()->with('info', 'Новость послана нахуй');
    }
}