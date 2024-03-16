<?php

namespace App\Http\Classes\LogicalModels\Auth;

use App\Models\MySql\Biodeposit\Roles;
use App\Models\MySql\Biodeposit\RoleUsers;
use App\Models\MySql\Biodeposit\User_setting;
use App\Models\MySql\Biodeposit\UserInfo as UserInfoTable;
use App\Models\MySql\Biodeposit\Users;

class AuthModel
{
    public function __construct(
        private Users $userModel,
        private UserInfoTable $userInfo,
        private RoleUsers $roleUsers,
        private Roles $roles,
        private User_setting $userSetting,

    ){}
    public function getUserInfo(string $email): ?array
    {
        return $this->userModel
            ->from($this->userModel->getTable(). ' as userModel')
            ->leftJoin($this->userInfo->getTable() . ' as userInfo',
                'userModel.id',
                '=',
                'userInfo.user_id'
            )
            ->leftJoin($this->userSetting->getTable() . ' as userSetting',
                'userModel.id',
                '=',
                'userSetting.user_id'
            )
            ->where('userModel.email',$email)
            ->select([
                'userModel.id',
                'userModel.email',
                'userSetting.locale',
                'userModel.permissions',
                'userModel.is_active_user',
                'userInfo.first_name',
                'userInfo.last_name',
                'userModel.google2fa_secret as secret_key',
            ])
            ->selectRaw('!ISNULL(userModel.google2fa_secret) as has_2fa_code')
            ->first()
            ?->toArray();
    }
    public function getUserRoles(int $id): array
    {
        return $this->roleUsers
            ->from($this->roleUsers->getTable(). ' as roleUsers')
            ->leftJoin($this->roles->getTable() . ' as roles',
                'roles.id',
                '=',
                'roleUsers.role_id'
            )
            ->where('roleUsers.user_id',$id)
            ->get()
            ->toArray();
    }
    public function set2fac(int $userId,string $code2fa): void
    {
        $this->userModel
            ->where('id',$userId)
            ->update([
                'google2fa_secret' => $code2fa
            ]);
    }
}
