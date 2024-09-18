<?php

namespace App\Http\Middleware;


use App\Exceptions\Middleware\PermissionDeniedException;
use App\Http\Facades\ResponseFacade;
use App\Http\Facades\UserInfoFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class CheckRolesMiddleware
{

    public function handle(Request $request, Closure $next,string ...$allowedRoles ): Response
    {
        $user = UserInfoFacade::getUserInfo('id',Auth::user()->id);
        $userPermissions = array_keys(array_filter(
            $user['roles']['permissions'] ?? [],
            fn($role) => !!$role
        ));
        if(in_array('superuser',$userPermissions)){
            return $next($request);
        }
        if (empty(array_intersect($allowedRoles, $userPermissions))) {
            return ResponseFacade::makeBadResponse(new PermissionDeniedException());
        }
        return $next($request);
    }
}
