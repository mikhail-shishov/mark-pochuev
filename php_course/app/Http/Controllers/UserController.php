<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('canManageUsers', User::class);
        $users = User::where('id', '!=', auth()->id())->get();
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $this->authorize('canManageUsers', User::class);

        $validated = $request->validate([
            'role' => 'required|in:admin,moderator,user',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Роль пользователя ' . $user->name . ' успешно обновлена.');
    }
}
