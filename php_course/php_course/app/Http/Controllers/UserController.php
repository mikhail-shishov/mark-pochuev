<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()?->canManageUsers()) {
            abort(403);
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()?->canManageUsers()) {
            abort(403);
        }

        $validated = $request->validate([
            'role' => 'required|string|in:admin,moderator,user',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', 'Роль пользователя обновлена!');
    }
}
