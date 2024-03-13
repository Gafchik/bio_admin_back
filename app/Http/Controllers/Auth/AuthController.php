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
        $this->google2fa = new Google2FA();
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
                $this->model->set2fac($user['id'],encrypt($code2fa));
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
        return $this->makeGoodResponse([]);
        $data = $request->validated();
        $user = $this->model->getUserInfo($data['email']);
        $code = $data['code'];
        $secretKey = decrypt($user['secret_key']);

        return $this->google2fa->verifyKey($secretKey,$code)
            ? $this->makeGoodResponse([])
            : $this->makeBadResponse(new Google2faCodeException());
    }
}
