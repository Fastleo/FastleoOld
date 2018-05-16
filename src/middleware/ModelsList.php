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
                $models[] = $pathInfo['filename'];
            }
        }
        $request->attributes->add(['models' => $models]);
        return $next($request);
    }
}