<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Авторизация
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->post('email') and $request->post('password')) {
            $user = User::where(['email' => $request->post('email'), 'admin' => 1])->first();
            if (Hash::check($request->post('password'), $user->getAuthPassword())) {
                $request->session()->put('id', $user->id);
                $request->session()->put('admin', $user->admin);
                $request->session()->save();
                return redirect('/fastleo/info');
            }
        }
        return view('fastleo::login');
    }

    /**
     * Выход
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->save();
        return redirect('/fastleo');
    }
}