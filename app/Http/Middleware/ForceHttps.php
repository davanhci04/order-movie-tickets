<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS in production or Railway
        if (config('app.env') === 'production' || 
            str_contains(config('app.url', ''), 'railway.app')) {
            
            if (!$request->isSecure() && !$request->header('x-forwarded-proto') === 'https') {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        return $next($request);
    }
}