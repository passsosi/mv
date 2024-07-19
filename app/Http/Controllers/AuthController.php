<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->save();

        //event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $formFields = $request->only('email', 'password');

        if (Auth::attempt($formFields)) {
            return redirect('/');
        }

        return redirect(route('login'))->withErrors(['email' => 'Неверный логин или пароль']);
    }
}
