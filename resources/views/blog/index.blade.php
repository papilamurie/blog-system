<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">📝 My Blog</h1>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Search</h3>
                    <form method="GET" action="{{ route('blog.index') }}">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search posts..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Search
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Categories</h3>
                    <div class="space-y-2">
                        <a href="{{ route('blog.index') }}" class="block text-gray-700 hover:text-blue-600 {{ !request('category') ? 'font-semibold text-blue-600' : '' }}">
                            All Posts
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                class="flex items-center justify-between text-gray-700 hover:text-blue-600 {{ request('category') == $category->slug ? 'font-semibold text-blue-600' : '' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs px-2 py-1 rounded" style="background-color: {{ $category->color }}22; color: {{ $category->color }}">
                                    {{ $category->posts_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tags -->
                @if($tags->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-lg mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-sm {{ request('tag') == $tag->slug ? 'bg-blue-100 text-blue-700' : '' }}">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

            <!-- Posts Grid -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                                <!-- Featured Image -->
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-6xl">📝</span>
                                    </div>
                                @endif

                                <div class="p-5">
                                    <!-- Category -->
                                    <span class="text-xs px-2 py-1 rounded inline-block mb-2" style="background-color: {{ $post->category->color }}22; color: {{ $post->category->color }}">
                                        {{ $post->category->name }}
                                    </span>

                                    <!-- Title -->
                                    <h2 class="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>

                                    <!-- Excerpt -->
                                    @if($post->excerpt)
                                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->excerpt, 100) }}</p>
                                    @else
                                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    @endif

                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>👁️ {{ number_format($post->views) }}</span>
                                        <span>💬 {{ $post->comments->count() }}</span>
                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <p class="text-gray-500 text-lg">No posts found.</p>
                        @if(request('search'))
                            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-900 mt-4 inline-block">
                                Clear search
                            </a>
                        @endif
                    </div>
                @endif
            </div>
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
