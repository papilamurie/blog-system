<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Posts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Posts</p>
                                <p class="text-3xl font-bold text-blue-600">
                                    {{ Auth::user()->posts()->count() }}
                                </p>
                            </div>
                            <div class="text-4xl">📝</div>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Published</p>
                                <p class="text-3xl font-bold text-green-600">
                                    {{ Auth::user()->posts()->published()->count() }}
                                </p>
                            </div>
                            <div class="text-4xl">✅</div>
                        </div>
                    </div>
                </div>

                <!-- Drafts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Drafts</p>
                                <p class="text-3xl font-bold text-orange-600">
                                    {{ Auth::user()->posts()->draft()->count() }}
                                </p>
                            </div>
                            <div class="text-4xl">📄</div>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Comments</p>
                                <p class="text-3xl font-bold text-purple-600">
                                    {{ App\Models\Comment::whereHas('post', fn($q) => $q->where('user_id', Auth::id()))->count() }}
                                </p>
                            </div>
                            <div class="text-4xl">💬</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.posts.create') }}" class="bg-gray-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            ✍️ New Post
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            📚 Manage Posts
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            🏷️ Categories
                        </a>
                        <a href="{{ route('admin.comments.index') }}" class="bg-gray-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            💬 Comments
                        </a>
                        <a href="{{ route('blog.index') }}" class="bg-gray-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" target="_blank">
                            🌐 View Blog
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Posts</h3>
                        <a href="{{ route('admin.posts.index') }}" class="text-blue-600 hover:text-blue-900">View All</a>
                    </div>

                    @php
                        $recentPosts = Auth::user()->posts()->with('category')->latest()->take(5)->get();
                    @endphp

                    @if($recentPosts->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentPosts as $post)
                                <div class="flex items-center justify-between border-b pb-3">
                                    <div class="flex-1">
                                        <a href="{{ route('admin.posts.show', $post) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                            {{ $post->title }}
                                        </a>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-xs px-2 py-1 rounded" style="background-color: {{ $post->category->color }}22; color: {{ $post->category->color }}">
                                                {{ $post->category->name }}
                                            </span>
                                            <span class="text-xs px-2 py-1 rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No posts yet. Create your first post!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
