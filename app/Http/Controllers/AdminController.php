<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function promoteUser(Request $request, User $user)
    {
        // Validate role input
        $validated = $request->validate([
            'role' => 'required|in:free,premium,admin',
        ]);

        // Prevent admin from demoting themselves accidentally
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->withErrors(['role' => 'You cannot change your own admin role.']);
        }

        // Update user role
        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', 'User role updated successfully.');
    }

    // List all users (admin only)
    public function listUsers()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10); // You can use simplePaginate()

        return view('admin.users', compact('users'));
    }
}
