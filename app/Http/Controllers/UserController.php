<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }
    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();


            return redirect()->intended('/news');
        }

        return back()->withErrors([
            'login' => 'Неправильный логин или пароль.. или вы неправильный dont cry.',
        ])->onlyInput('login');
    }
    public function getReg()
    {
        return view('reg');
    }
    public function postReg(Request $request)
    {
        $validated = $request->validate([
            'login'     => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'login'    => $validated['login'],
            'password' => Hash::make($validated['password']),
            'role'     => User::ROLE_READER,
            'gender'   => User::GENDER_MALE,
            'bio'      => null,
            'avatar'   => null,
        ]);

        Auth::login($user);

        return redirect()->intended('/news');
    }

    public function getLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/news');
    }

}
