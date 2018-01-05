<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App;
use Config;

class SetLocale
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
        if (!$request->is('login')) {
            try {
                $locale = Auth::user()->lang;
                App::setLocale($locale);
            } catch (Exception $e) {
                App::setLocale(Config::get('app.locale'));
            }
        }

        return $next($request);
    }
}
