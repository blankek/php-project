<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.roles.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|in:' . implode(',', [
                User::ROLE_READER,
                User::ROLE_EDITOR,
                User::ROLE_ADMIN,
                User::ROLE_MODERATOR,
            ]),
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Роль пользователя {$user->login} обновлена на {$validated['role']}");
    }
}
