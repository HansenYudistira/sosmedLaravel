<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('auth.login', ["title" => 'Login']);
    }

    protected function authenticated(Request $request, $user) {
        if (!$user) {
            return redirect()->back()->withInput($request->only('email', 'remember'));
        }
        return redirect()->route('index');
    }

    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
