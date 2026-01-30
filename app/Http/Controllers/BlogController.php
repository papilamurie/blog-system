<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
{
    $query = Post::with(['user', 'category', 'tags'])
        ->published()
        ->latest('published_at');

    // Search
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }

    // Filter by category
    if ($request->has('category') && $request->category) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    // Filter by tag
    if ($request->has('tag') && $request->tag) {
        $query->whereHas('tags', function ($q) use ($request) {
            $q->where('slug', $request->tag);
        });
    }

    $posts = $query->paginate(9);

    // Get categories with published post counts only
    $categories = Category::withCount(['posts' => function ($q) {
        $q->published();
    }])->get();

    // Get tags that have published posts
    $tags = Tag::whereHas('posts', function ($q) {
        $q->published();
    })->get();

    return view('blog.index', compact('posts', 'categories', 'tags'));
}

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'comments' => function ($query) {
                $query->approved()->with('user')->latest();
            }])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'approved' => false, // Requires approval
        ]);

        return back()->with('success', 'Comment submitted! It will appear after approval.');
    }
}
