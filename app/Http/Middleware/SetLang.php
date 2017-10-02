<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session()->has('lang'))
        {
            session(['lang' => App::getLocale()]);
        }
        App::setLocale(session('lang'));
        return $next($request);
    }
}

?>