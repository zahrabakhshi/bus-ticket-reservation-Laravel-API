<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class
PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {

        if (Auth::check()) {// id user is registered in web appication:

            $user = Auth::user();

            $user_roles = $user->roles()->pluck('name')->toArray();// create user_roles array

            foreach ($roles as $role) {// check if user_roles array contain all roles define in permission middleware
                if (!in_array($role, $user_roles)) {
                    abort(403);
                }
            }

            return $next($request);

        } else {// if user is not registered in web application
            abort(403);
        }


    }
}
