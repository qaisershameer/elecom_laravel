<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the authenticated user's role
        $authUserRole = Auth::user()->role;

        // Determine if the user's role matches the required role
        switch ($role) {
            case 'admin':
                if ($authUserRole == 0) {
                    return $next($request);
                }
                break;

            case 'vendor':
                if ($authUserRole == 1) {
                    return $next($request);
                }
                break;

            case 'customer':
                if ($authUserRole == 2) {
                    return $next($request);
                }
                break;
        }

        // Redirect based on the user's role if they do not have access
        switch ($authUserRole) {
            case 0:
                return redirect()->route('admin');
            case 1:
                return redirect()->route('vendor');
            case 2:
                return redirect()->route('dashboard');
            default:
                return redirect()->route('login');
        }

        // This return statement is to satisfy the return type hint, though it shouldn't be reached
        return response()->noContent(); // or throw an exception if desired
    }
}
