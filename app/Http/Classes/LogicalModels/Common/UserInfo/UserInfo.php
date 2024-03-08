<?php

namespace App\Http\Classes\LogicalModels\Common\UserInfo;

class UserInfo implements UserInfoInterface
{
    public function __construct(
        private UserInfoModel $model
    ){}

    public function getUserInfo(string $fieldName, string $fieldValue): array
    {
        return $this->model->getUserInfo($fieldName, $fieldValue);
    }
}
