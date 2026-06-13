<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LighthouseAuthBypass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');

        // Check if the user agent belongs to PageSpeed Insights (Lighthouse)
        if ($userAgent && str_contains($userAgent, 'Chrome-Lighthouse')) {
            // Bypass auth by temporarily logging in the first available user
            if (!Auth::check()) {
                $user = User::first();
                if ($user) {
                    Auth::login($user);
                }
            }
            return $next($request);
        }

        return $next($request);
    }
}
