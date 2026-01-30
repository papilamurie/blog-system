<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Comments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($comments as $comment)
                                <div class="border rounded-lg p-4 {{ !$comment->approved ? 'bg-yellow-50' : '' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <p class="font-semibold">{{ $comment->user->name }}</p>
                                                @if(!$comment->approved)
                                                    <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs">Pending Approval</span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">Approved</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">
                                                On: <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-blue-600 hover:text-blue-900">
                                                    {{ $comment->post->title }}
                                                </a>
                                            </p>
                                            <p class="text-gray-800">{{ $comment->content }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            @if(!$comment->approved)
                                                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $comments->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-12">No comments yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
