<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
class Language
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
        
        if (Session::has('locale') && in_array(Session::get('locale'), ['en', 'zh'])) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale('zh');
        }
        return $next($request);
    }
}
