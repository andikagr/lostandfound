<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LighthouseAuthBypass extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $userAgent = $request->header('User-Agent', '');

        // Broaden the check for PageSpeed Insights, Lighthouse, Googlebot, etc.
        if (preg_match('/Lighthouse|Googlebot|Page Speed|PTST/i', $userAgent)) {
            // Bypass auth by temporarily logging in the first available user
            if (!Auth::check()) {
                $user = User::first();
                if ($user) {
                    Auth::login($user);
                }
            }
            return $next($request);
        }

        return parent::handle($request, $next, ...$guards);
    }
}
