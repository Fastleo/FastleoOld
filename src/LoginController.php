<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Авторизация
     * @return mixed
     */
    public function login(Request $request)
    {
        if (count($request->post()) > 0) {
            if (Auth::attempt(['email' => $request->post('email'), 'password' => $request->post('password'), 'admin' => 1])) {
                return redirect()->intended('/fastleo/info');
            }
        }
        return view('fastleo::login');
    }

    /**
     * Выход
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/fastleo');
    }
}