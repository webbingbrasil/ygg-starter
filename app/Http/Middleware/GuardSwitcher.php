<?php


namespace App\Http\Middleware;

class GuardSwitcher
{
    public function handle($request, \Closure $next, $defaultGuard = null) {
        if (array_key_exists($defaultGuard, config('auth.guards'))) {
            auth()->setDefaultDriver($defaultGuard);
        }

        return $next($request);
    }
}
