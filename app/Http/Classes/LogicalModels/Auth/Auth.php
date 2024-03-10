<?php

namespace App\Http\Classes\LogicalModels\Auth;

class Auth
{
    public function __construct(
        private AuthModel $model
    ){}
    public function getUserInfo(string $email): ?array
    {
        return $this->model->getUserInfo($email);
    }
}
