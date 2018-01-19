<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        if(Auth::check()) {
            return redirect('/');
        }
        return view('login');
    }

    public function authenticate(Request $request) {
        $name = $request->input('name');
        $password = $request->input('password');
        if(Auth::attempt(['name' => $name, 'password' => $password])) {
            return redirect()->intended('/');
        }
    }

    public function register(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        User::insert(['name' => $name, 'email' => $email, 'password' => bcrypt($password), 'created_at' =>  date('Y-m-d H:i:s'), 'permissions' => 0, 'api_token' => str_random(60)]);
        return redirect('/login');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
