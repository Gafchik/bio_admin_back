<?php

namespace App\Http\Classes\LogicalModels\Auth;

use App\Models\MySql\Biodeposit\DemoBalance;
use App\Models\MySql\Biodeposit\DicCurrencies;
use App\Models\MySql\Biodeposit\Trees;
use App\Models\MySql\Biodeposit\UserInfo as UserInfoTable;
use App\Models\MySql\Biodeposit\Users;
use App\Models\MySql\Biodeposit\Wallets;

class AuthModel
{
    public function __construct(
        private Users $userModel,
        private UserInfoTable $userInfo,

    ){}
    public function getUserInfo(string $email): ?array
    {
        //TODO add roles
        return $this->userModel
            ->from($this->userModel->getTable(). ' as userModel')
            ->leftJoin($this->userInfo->getTable() . ' as userInfo',
                'userModel.id',
                '=',
                'userInfo.user_id'
            )
            ->where('userModel.email',$email)
            ->select([
                'userModel.email',
                'userModel.permissions',
                'userModel.is_active_user',
                'userInfo.first_name',
                'userInfo.last_name',
            ])
            ->first()
            ?->toArray();
    }
}
