<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        if ($request->filter === 'unread') {
            $query->where('read', false);
        } elseif ($request->filter === 'read') {
            $query->where('read', true);
        }

        $notifications = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        
        return view('notifications.index', compact('notifications'));
    }


    public function markAsRead(Notification $notification)
    {
        $this->authorize('view', $notification);

        $notification->update(['read' => true]);

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->update(['read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

}
