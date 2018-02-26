<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $columns = User::select('name', 'email')->where('id', '=', Auth::id())->first();
        return view('profile', ['columns' => $columns]);
    }

    public function update(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $passwordRepeat = $request->input('password-repeat');

        $columns = User::select('name', 'email')->where('id', '=', Auth::id())->first();
        if ($name !== $columns->name) {
            if (!User::select('name')->where('name', '=', $name)->first()) {
                User::where('id', '=', Auth::id())->update(['name' => $name]);
            }
        }

        if ($email !== $columns->email) {
            if (!User::select('email')->where('email', '=', $email)->first()) {
                User::where('id', '=', Auth::id())->update(['email' => $email]);
            }
        }

        if (!empty($password) || !empty($passwordRepeat)) {
            if ($password === $passwordRepeat) {
                User::where('id', '=', Auth::id())->update(['password' => bcrypt($password)]);
            }
        }

        return redirect('/user/profile');
    }
}
