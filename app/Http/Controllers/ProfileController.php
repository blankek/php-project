<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'login' => ['required', 'string', 'max:25', 'unique:users,login,' . $user->id],
            'bio' => ['nullable', 'string', 'max:1000'],
            'gender' => ['required', 'in:male,female'],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10240',
                'dimensions:max_width=2048,max_height=2048',
            ],
        ], [
            'login.required' => 'Логин обязателен для заполнения',
            'login.unique' => 'Этот логин уже занят',
            'login.max' => 'Логин не должен превышать 25 символов',
            'bio.max' => 'Описание не должно превышать 1000 символов',
            'gender.required' => 'Пожалуйста, выберите пол',
            'gender.in' => 'Некорректное значение пола',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Поддерживаемые форматы: JPEG, PNG, JPG, GIF, WEBP',
            'avatar.max' => 'Размер фото не должен превышать 10 МБ',
            'avatar.dimensions' => 'Размеры изображения не должны превышать 2048x2048 пикселей',
        ]);

        $user->login = $validated['login'];
        $user->bio = $validated['bio'] ?? null;
        $user->gender = $validated['gender'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Профиль успешно обновлен!',
            'user' => [
                'login' => $user->login,
                'bio' => $user->bio,
                'gender' => $user->gender,
                'avatar' => $user->getAvatarUrl(),
                'created_at' => $user->getFormattedCreatedAt()
            ]
        ]);
    }
}
