<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function index()
    {
        $params = [];

        $params[] = [
            'title' => 'Версия Fastleo',
            'value' => Config::get('fastleo_composer')->version
        ];

        $params[] = [
            'title' => 'Версия Laravel',
            'value' => app()->version()
        ];

        $params[] = [
            'title' => 'Версия PHP',
            'value' => phpversion()
        ];

        $params[] = [
            'title' => 'Драйвер БД',
            'value' => env('DB_CONNECTION')
        ];

        return view('fastleo::info', [
            'params' => $params
        ]);
    }

    public function clean()
    {

    }
}