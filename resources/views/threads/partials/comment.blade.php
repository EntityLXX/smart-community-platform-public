<div x-data="{ editing: false, moderate: false, content: @js($comment->content) }" class="border-b pb-3 mb-3 pl-{{ $depth * 6 }}">
    {{-- Same comment display logic as you currently have, adjusted for $depth --}}
    {{-- You may keep truncation, edit/delete/moderate UI here --}}

    {{-- Reply Form --}}
    <div x-data="{ showReply: false }" class="mt-2">
        <button @click="showReply = !showReply" class="text-xs text-blue-500 hover:underline">↪ Reply</button>

        <div x-show="showReply" x-cloak class="mt-2">
            <form action="{{ route('comments.store', $comment->thread) }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" required
                    class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white"
                    placeholder="Write your reply..."></textarea>
                <div class="mt-1 flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Reply</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Nested Replies --}}
    @foreach ($comment->replies as $reply)
        @include('threads.partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
    @endforeach
</div>
