<?php

namespace Camanru\Fastleo;

use Closure;
use Illuminate\Http\Request;

class ModelsList
{
    /**
     * Models list
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $models = [];
        foreach (scandir(base_path('app')) as $file) {
            $pathInfo = pathinfo($file);
            if (isset($pathInfo['extension']) and $pathInfo['extension'] == 'php') {
                if (class_exists('App\\' . $pathInfo['filename'])) {
                    $name = 'App\\' . $pathInfo['filename'];
                    $app = (new $name())->fastleo;
                    if (is_null($app) or $app == true) {
                        $models[strtolower($pathInfo['filename'])] = $pathInfo['filename'];
                    }
                }
            }
        }
        $request->appmodels = $models;
        return $next($request);
    }
}