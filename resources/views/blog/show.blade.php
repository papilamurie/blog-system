<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('blog.index') }}" class="text-3xl font-bold text-gray-900 hover:text-blue-600">📝 My Blog</a>
                <div class="flex gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                        <a href="{{ route('register') }}" class="bg-gray-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <a href="{{ route('blog.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-900 mb-6">
            ← Back to Blog
        </a>

        <!-- Post -->
        <article class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Featured Image -->
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
            @endif

            <div class="p-8">
                <!-- Category & Tags -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 rounded text-sm" style="background-color: {{ $post->category->color }}22; color: {{ $post->category->color }}">
                        {{ $post->category->name }}
                    </span>
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-sm">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                <!-- Meta -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6 pb-6 border-b">
                    <span>By {{ $post->user->name }}</span>
                    <span>•</span>
                    <span>{{ $post->published_at->format('F d, Y') }}</span>
                    <span>•</span>
                    <span>👁️ {{ number_format($post->views) }} views</span>
                    <span>•</span>
                    <span>💬 {{ $post->comments->count() }} comments</span>
                </div>

                <!-- Excerpt -->
                @if($post->excerpt)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <p class="text-gray-700 italic text-lg">{{ $post->excerpt }}</p>
                    </div>
                @endif

                <!-- Content -->
                <!-- Content -->
                    <div class="prose prose-lg max-w-none mb-8">
                        {!! Str::markdown($post->content) !!}
                    </div>

                <!-- Share Buttons -->
                <div class="border-t pt-6">
                    <p class="text-sm text-gray-600 mb-2">Share this post:</p>
                    <div class="flex gap-3">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                            target="_blank" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded">
                            Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                            target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Facebook
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post->slug)) }}"
                            target="_blank" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-4xl">📝</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-2 hover:text-blue-600">
                                    <a href="{{ route('blog.show', $related->slug) }}">{{ Str::limit($related->title, 60) }}</a>
                                </h3>
                                <p class="text-sm text-gray-600">{{ $related->published_at->format('M d, Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Comments Section -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Comments ({{ $post->comments->count() }})
            </h2>

            <!-- Comment Form -->
            @auth
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('blog.comment.store', $post) }}" class="mb-8">
                    @csrf
                    <textarea name="content" rows="4" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Write your comment...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="mt-2 bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Post Comment
                    </button>
                </form>
            @else
                <div class="bg-gray-100 border border-gray-300 rounded p-4 mb-8">
                    <p class="text-gray-700">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-900">Login</a> or
                        <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-900">register</a> to leave a comment.
                    </p>
                </div>
            @endauth

            <!-- Comments List -->
            @if($post->comments->count() > 0)
                <div class="space-y-6">
                    @foreach($post->comments as $comment)
                        <div class="border-b pb-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <p class="font-semibold text-gray-900">{{ $comment->user->name }}</p>
                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-sm mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} My Blog. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
