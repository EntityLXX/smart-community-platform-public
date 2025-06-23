<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Notification;
use App\Models\User;
use App\Models\ThreadView;


class ThreadController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Load announcements with view and comment counts, plus replies for nested counting
        $announcements = Thread::where('type', 'announcement')
            ->withCount(['views', 'comments'])
            ->with(['user', 'comments.replies']) // for replies count
            ->latest()
            ->paginate(5, ['*'], 'announcements');

        // Load normal threads with the same structure
        $threads = Thread::where('type', 'normal')
            ->withCount(['views', 'comments'])
            ->with(['user', 'comments.replies']) // for replies count
            ->latest()
            ->paginate(5, ['*'], 'threads');

        return view('threads.index', compact('announcements', 'threads'));
    }


    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
            'content' => 'required',
            'type' => 'nullable|in:normal,announcement'
        ]);

        $type = $request->type ?? 'normal';

        $thread = Thread::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'type' => $type,
        ]);

        // Notify all users only if an admin posts an announcement
        if ($type === 'announcement' && Auth::user()?->role === 'admin') {
            $users = User::where('id', '!=', Auth::id())->get(); // skip notifying yourself

            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'New Announcement Posted',
                    'message' => "An announcement titled \"{$thread->title}\" has been posted. Check the Communication Hub for details.",
                    'read' => false,
                ]);
            }
        }

        return redirect()->route('threads.index')->with('success', 'Thread posted.');
    }

    public function show(Thread $thread)
    {
        // Record view if user is logged in and hasn't viewed before
        if (auth()->check()) {
            ThreadView::firstOrCreate([
                'thread_id' => $thread->id,
                'user_id' => auth()->id(),
            ]);
        }

        // Efficiently load only the count of views
        $thread->loadCount('views');

        // Load comments + replies
        $comments = $thread->comments()
            ->with([
                'user',
                'replies' => function ($query) {
                    $query->with('user')->oldest(); // replies ordered oldest-first
                }
            ])
            ->whereNull('parent_id')
            ->oldest() // top-level comments oldest-first
            ->get();

        return view('threads.show', compact('thread', 'comments'));
    }

    public function destroy(Thread $thread)
    {
        if (Auth::id() === $thread->user_id || Auth::user()->isAdmin()) {
            $thread->delete();
            return redirect()->route('threads.index')->with('success', 'Thread deleted.');
        }

        abort(403);
    }

    public function edit(Thread $thread)
    {
        $this->authorize('update', $thread);
        return view('threads.edit', compact('thread'));
    }

    public function update(Request $request, Thread $thread)
    {
        $this->authorize('update', $thread);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:500',
            'content' => 'required',
            'type' => 'required|in:normal,announcement'
        ]);

        $thread->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'type' => $request->type,
        ]);

        return redirect()->route('threads.show', $thread)->with('success', 'Thread updated.');
    }

    public function destroyWithReason(Request $request, Thread $thread)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        Notification::create([
            'user_id' => $thread->user_id,
            'title' => 'Thread Removed by Admin',
            'message' => "Your thread \"{$thread->title}\" was removed. Reason: {$request->reason}",
            'read' => false,
        ]);

        $thread->delete();

        return redirect()->route('threads.index')->with('success', 'Thread deleted with reason.');
    }


}
