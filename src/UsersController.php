<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('fastleo::users');
    }
}