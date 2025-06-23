<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtering by role or search keyword
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Prioritize admins at the top unless filtered
        if (!$request->filled('role')) {
            $query->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END");
        }

        $users = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot delete the Super Admin.');
        }

        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin user.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();

        // Disallow editing Super Admin unless it's self
        if ($user->isSuperAdmin() && $authUser->id !== $user->id) {
            return back()->with('error', 'You are not allowed to edit the Super Admin.');
        }

        // Disallow normal admins from editing themselves or other admins
        if (!$authUser->isSuperAdmin()) {
            if ($authUser->id === $user->id || $user->isAdmin()) {
                return back()->with('error', 'You are not allowed to edit this user.');
            }
        }

        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();

        // Disallow editing Super Admin unless it's self
        if ($user->isSuperAdmin() && $authUser->id !== $user->id) {
            return back()->with('error', 'You are not allowed to modify the Super Admin.');
        }

        // Disallow normal admins from updating themselves or other admins
        if (!$authUser->isSuperAdmin()) {
            if ($authUser->id === $user->id || $user->isAdmin()) {
                return back()->with('error', 'You are not allowed to update this user.');
            }
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
            'can_manage_facility' => 'nullable|boolean',
        ]);

        $user->role = $validated['role'];
        $user->can_manage_facility = $validated['can_manage_facility'] ?? false;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }




    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'You cannot change the role of the Super Admin.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'User role updated successfully.');
    }


    public function toggleFacilityAccess(User $user)
    {
        if ($user->role !== 'admin') {
            return back()->with('error', 'Only admins can be granted this permission.');
        }

        $user->can_manage_facility = !$user->can_manage_facility;
        $user->save();

        return back()->with('success', 'Facility management access updated.');
    }


}