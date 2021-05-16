<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission)
    {
        $user_permission = auth()->user()->user_permission->pluck('name')->toArray();
//        dd($user_permission);
//        dd($this->checkData($user_permission,$permission));
        if ($this->checkData($user_permission,$permission)) {
            return $next($request);
        }
        else {
            throw new HttpException(422, 'User is not permitted to perform this action');
        }
    }

    public function checkData( $myarr,$myvalue )
    {
        foreach( $myarr as $key => $value ){
            if($myvalue === $value){
                return true;
            }
        }
        return false;
    }
}
