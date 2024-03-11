<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Auth\Auth as AuthModel;
use App\Http\Classes\LogicalModels\Auth\Exceptions\Google2faCodeException;
use App\Http\Classes\LogicalModels\Auth\Exceptions\UnauthorizedException;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\Auth\Google2facRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class AuthController extends BaseController
{
    private Google2FA $google2fa;
    public function __construct(
        private AuthModel $model
    )
    {
        $this->google2fa = new Google2FA();;
        $this->middleware('auth:api', ['except' => [
            'login',
        ]]);
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
            $user = $this->model->getUserInfo($data['email']);
            $has2Fac = $user['has_2fa_code'];
            if(!$has2Fac){
                $code2fa = $this->google2fa->generateSecretKey();
                $this->model->set2fac($user['id'],$code2fa);
                $QR_Image =$this->google2fa->getQRCodeInline(
                    config('app.name'),
                    $user['email'],
                    $code2fa
                );
            }

            //TODO делать свои пермишны ?
//            $roles = $this->model->getUserRoles($user['id']);
            return $this->makeGoodResponse([
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'user' =>  $user,
                'has_2fa_code' => $has2Fac,
                'qr' => $QR_Image ?? null,
//                'roles' => $roles,
            ]);
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
    }
    public function logout(): JsonResponse
    {
        Auth::logout();
        return $this->makeGoodResponse([]);
    }
    public function google2fac(Google2facRequest $request): JsonResponse
    {
        $user = Auth::user();

        return $this->makeGoodResponse([$user->email]);
//        $data = $request->validated();
//        $user = $this->model->getUserInfo($data['email']);
//        $code = $data['code'];
//        $secretKey = $user['secret_key'];
//
//        $secretKey = json_decode(base64_decode($user['secret_key']),true);
////        $secretKey = json_decode(base64_decode($user['secret_key']),true)['value'];
////        dd($this->google2fa->verifyKey($secretKey,$code));
//        $google2fa = app('pragmarx.google2fa');
//
//        dd(
//            $secretKey,
////            $google2fa->verifyKey($secretKey,$code),
//            json_decode(base64_decode($user['secret_key']),true),
//        );
//        if($this->google2fa->verifyKey($secretKey,$code)){
//            return $this->makeGoodResponse([]);
//        }else{
//            return $this->makeBadResponse(new Google2faCodeException());
//        }
    }
}