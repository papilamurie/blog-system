<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.posts.edit', $post) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Post Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- Featured Image -->
                    @if($post->featured_image)
                       <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
                    @endif

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-3 mb-6 text-sm text-gray-600">
                        <span class="px-3 py-1 rounded" style="background-color: {{ $post->category->color }}22; color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </span>
                        <span class="px-3 py-1 rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                        <span>👁️ {{ number_format($post->views) }} views</span>
                        <span>💬 {{ $post->comments->count() }} comments</span>
                        <span>📅 {{ $post->created_at->format('M d, Y') }}</span>
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($post->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Excerpt -->
                    @if($post->excerpt)
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                            <p class="text-gray-700 italic">{{ $post->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">
                        Comments ({{ $post->comments->count() }})
                    </h3>

                    @if($post->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($post->comments as $comment)
                                <div class="border-b pb-4 {{ !$comment->approved ? 'bg-yellow-50 p-3 rounded' : '' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold">{{ $comment->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex gap-2">
                                            @if(!$comment->approved)
                                                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm">Approve</button>
                                                </form>
                                            @else
                                                <span class="text-green-600 text-sm">✓ Approved</span>
                                            @endif
                                            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No comments yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
