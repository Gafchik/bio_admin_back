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
    public function getUserRoles(int $id): array
    {
        return $this->model->getUserRoles($id);
    }
    public function set2fac(int $userId,string $code2fa): void
    {
        $this->model->set2fac($userId,$code2fa);
    }
}
