<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  The role to check
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        
        // Check if the user is authenticated
        if (!Auth::check()) {
           abort(401);
        }

        
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's role matches the required role
        if ($user->role !== $role) {
          abort(401);; // Unauthorized if roles don't match
        }

        // Proceed with the request if authenticated and role matches
        return $next($request);
    }
}


