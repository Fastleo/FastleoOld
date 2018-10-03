<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    /**
     * Info page
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $params = [];
        $phpversion = explode("-", phpversion());

        if (env('DB_CONNECTION') == 'mysql') {
            $db = DB::select('SELECT version() as server_version;');
        } elseif (env('DB_CONNECTION') == 'pgsql') {
            $db = DB::select('SHOW server_version;');
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            $db = DB::select('SELECT sqlite_version() AS server_version;');
        } else {
            $db[0] = new \stdClass();
            $db[0]->server_version = '';
        }

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
            'value' => $phpversion[0]
        ];

        $params[] = [
            'title' => 'Драйвер БД',
            'value' => env('DB_CONNECTION') . ' ' . $db[0]->server_version ?? ''
        ];

        return view('fastleo::info', [
            'params' => $params
        ]);
    }

    /**
     * Clear cache
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        header('Location: ' . route('fastleo.info'));
        die;
    }
}