<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::with('role')->where('id', '!=', auth()->id())->get();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('users.index')->with('success', 'Пользователь успешно создан!');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Данные пользователя обновлены!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Пользователь удален!');
    }

    public function updateRole(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update(['role_id' => $validated['role_id']]);

        return redirect()->route('users.index')->with('success', 'Роль пользователя ' . $user->name . ' успешно обновлена.');
    }
}
