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
        $userRolePermissions = [];
        foreach ($user['roles'] as $role) {
            $permissions = json_decode($role['permissions'], true) ?? [];
            $filteredPermissions = array_filter($permissions, function ($value) {
                return $value === true;
            });
            $userRolePermissions = array_merge($userRolePermissions, $filteredPermissions);
        }
        $userPermissions = json_decode($user['permissions'], true);
        $filteredUserPermissions = array_filter($userPermissions, function ($value) {
            return $value === true;
        });
        $userRolePermissions = array_merge($userRolePermissions, $filteredUserPermissions);
        if(in_array('superuser',$userRolePermissions)){
            return $next($request);
        }
        if (empty(array_intersect($allowedRoles, $userRolePermissions))) {
            return ResponseFacade::makeBadResponse(new PermissionDeniedException());
        }
        return $next($request);
    }
}
