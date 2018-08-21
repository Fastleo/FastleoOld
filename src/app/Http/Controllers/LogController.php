<?php

namespace Camanru\Fastleo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    /**
     * View lo rows
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $log_file = file_get_contents(base_path('storage/logs/laravel.log'));
        $logs = explode("\n", $log_file);
        foreach ($logs as $k => $log) {
            if (substr($log, 0, 3) != '[20') {
                unset($logs[$k]);
            }
        }
        return view('fastleo::log', [
            'logs' => array_reverse($logs)
        ]);
    }

    /**
     * Clear lo file
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function clear()
    {
        file_put_contents(base_path('storage/logs/laravel.log'), '');
        header('Location: /fastleo/log');
        die;
    }
}