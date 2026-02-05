<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->where('user_id', Auth::id())
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generate slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle image upload - CHANGED TO S3
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('posts');
        }

        // Create post
        $post = Post::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'featured_image' => $imagePath,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        // Attach tags
        if (!empty($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->load(['category', 'tags', 'comments.user']);

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Handle image upload - CHANGED TO S3
        if ($request->hasFile('featured_image')) {
            // Delete old image from S3
            if ($post->featured_image) {
                Storage::delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts');
        }

        // Update published_at if status changed to published
        if ($validated['status'] === 'published' && $post->status === 'draft') {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Sync tags
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete image from S3
        if ($post->featured_image) {
            Storage::delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}
