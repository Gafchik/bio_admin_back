<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Auth\Auth;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Facades\UserInfoFacade;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __construct(
        private Auth $model
    )
    {
        parent::__construct();
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $userInfo = UserInfoFacade::getUserInfo('email',$data['email']);
            $res = Hash::check($userInfo['password_hash'],$data['password_hash']);
            dd($res);
            return $this->makeGoodResponse(request()->input());
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
    }
}
