<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class
PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,...$roles)
    {
        //get roles of current user
        $user = auth('api')->user();
        $userRoles = $user->roles()->pluck('name')->toArray();

        //check is roles contain specific role er define in middleware or not?
        foreach ($roles as $role){
            if(!in_array($role, $userRoles)){
                return response()->json(['error' => 'Forbidden'], 403);
            }
        }
        return $next($request);
    }
}
