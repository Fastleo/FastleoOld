<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

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
            'value' => env('DB_CONNECTION')
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