<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    // Store a new comment
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $thread->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('threads.show', $thread)->with('success', 'Comment added.');
    }


    // Edit view (optional, if you're using a separate form)
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    // Update the comment
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('threads.show', $comment->thread)->with('success', 'Comment updated.');
    }

    // Delete the comment
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->route('threads.show', $comment->thread)->with('success', 'Comment deleted.');
    }

    public function destroyWithReason(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Store notification for the user who posted the comment
        Notification::create([
            'user_id' => $comment->user_id,
            'title' => 'Comment Removed by Admin',
            'message' => "Your comment was removed. Reason: {$request->reason}",
            'read' => false,
        ]);

        $comment->delete();

        return redirect()->route('threads.show', $comment->thread)->with('success', 'Comment deleted with reason.');
    }
}
