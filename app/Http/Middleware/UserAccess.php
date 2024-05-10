<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        if (auth()->user()->role == $userType || auth()->user()->role == 'superadmin') {
            return $next($request);
        }

        $notification = array(
            'message' => 'You do not have permission to access for this page.',
            'alert-type' => 'error',
        );

        return redirect()->back()->with($notification);
    }
}
