<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $currentRoute = $request->route()->getName();

        if ($user->hasPermission($currentRoute)) {
            return $next($request);
        }

        return redirect()->route('frontend.home');
    }
}
