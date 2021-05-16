<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role)
    {
        $user_role = auth()->user()->role->name;

        if ($user_role == $role) {
            return $next($request);
        }
        else {
            throw new HttpException(422, 'User is not permitted to perform this action');
        }
    }
}
