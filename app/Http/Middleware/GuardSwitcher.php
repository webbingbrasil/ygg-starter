<?php

namespace App\Http\Middleware;

use Auth;
use Config;
use Closure;
use function array_key_exists;

class GuardSwitcher
{
    public function handle($request, Closure $next, $defaultGuard = null)
    {
        if (array_key_exists($defaultGuard, Config::get('auth.guards'))) {
            Auth::setDefaultDriver($defaultGuard);
        }

        return $next($request);
    }
}
