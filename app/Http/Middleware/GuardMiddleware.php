<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class GuardMiddleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    // protected $except = [
    //     'callback', // Add your route here to exclude from CSRF protection
    // ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       // if ($request->is('callback')) {
       //     app(VerifyCsrfToken::class)->addExcept('callback');
       // }
        return $next($request);
    }
}
