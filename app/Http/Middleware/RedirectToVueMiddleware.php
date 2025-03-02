<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToVueMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is NOT for Vue.js routes or API routes. app = (vue routes)
        if (
            !$request->is('app') && 
            !$request->is('api/*')
        ) {
            // Redirect to the Vue.js landing page.
            return redirect('/app');
        }

        return $next($request);
    }
}
