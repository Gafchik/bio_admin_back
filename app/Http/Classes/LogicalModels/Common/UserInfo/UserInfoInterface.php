<?php

namespace App\Http\Classes\LogicalModels\Common\UserInfo;

interface UserInfoInterface
{
    public function getUserInfo(string $fieldName, string $fieldValue): array;
}
