<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Users list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::get();
        return view('fastleo::users', [
            'users' => $users
        ]);
    }

    /**
     * Create form user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('fastleo::users-edit');
    }

    /**
     * Edit form user
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($user_id)
    {
        $user = User::where('id', $user_id)->first();
        return view('fastleo::users-edit', [
            'user' => $user
        ]);
    }

    /**
     * Edit or create user
     * @param Request $request
     * @param null $user_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, $user_id = null)
    {
        if (count($request->all()) > 0) {

            // user data
            $userData = [
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'admin' => $request->post('admin'),
            ];

            // user password
            if ($request->post('password') != '') {
                if (md5($request->post('password')) == md5($request->post('repeat-password'))) {
                    $userData['password'] = bcrypt($request->post('password'));
                }
            }

            // Edit or create user
            if (!is_null($user_id)) {
                User::where('id', $user_id)->update($userData + ['updated_at' => \Carbon\Carbon::now()]);
                return redirect()->route('fastleo.users.edit', [$user_id]);
            } else {
                User::insert($userData + ['created_at' => \Carbon\Carbon::now()]);
            }
        }

        return redirect()->route('fastleo.users');
    }
}