<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        // Get comments on user's posts
        $comments = Comment::whereHas('post', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['post', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        // Check if comment belongs to user's post
        if ($comment->post->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->approve();

        return back()->with('success', 'Comment approved!');
    }

    public function destroy(Comment $comment)
    {
        // Check if comment belongs to user's post
        if ($comment->post->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}
