<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and allow access only to users
     * whose role matches the role required by the route.
     * @param  string   $role  The role required to access the route.
     */
    public function handle(Request $request,Closure $next,string $role): Response 
    {
        /*
         * Reject the request when no authenticated user is available or
         * the authenticated user's role does not match
         * the role required by the route.
         */
        if (
            !$request->user()
            || $request->user()->role !== $role
        ) {
            abort(
                403,
                'You are not authorized to access this area.'
            );
        }

        /*
         * The user has the correct role
         */
        return $next($request);
    }
}