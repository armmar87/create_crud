<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class Locale
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
        if (Cookie::has('locale')){
            app()->setLocale(Cookie::get('locale'));
        }
        elseif(Session::has('locale')){
            app()->setLocale(Session::get('locale'));
        }
        return $next($request);
    }
}
