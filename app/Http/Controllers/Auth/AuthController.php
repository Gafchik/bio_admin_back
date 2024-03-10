<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Auth\Auth as AuthModel;
use App\Http\Classes\LogicalModels\Auth\Exceptions\UnauthorizedException;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Facades\UserInfoFacade;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function __construct(
        private AuthModel $model
    )
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        parent::__construct();
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            if(empty($token)){
                throw new UnauthorizedException();
            }
            return $this->makeGoodResponse([
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'user' =>  $this->model->getUserInfo($data['email']),
            ]);
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
    }
}
