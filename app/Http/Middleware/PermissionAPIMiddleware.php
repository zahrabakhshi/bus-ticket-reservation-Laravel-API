<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionAPIMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next ,...$roles)
    {
        $user = auth('api')->user();
        $user_roles = $user->roles()->pluck('name')->toArray();// create user_roles array


        foreach ($roles ?? [] as $role) {// check if user_roles array contain all roles define in permission middleware
            if (!in_array($role, $user_roles)) {
                return response()->json([
                    'error' => 'Forbidden',
                    'status' => 403
                ]);
            }
        }

        return $next($request);
    }
}
