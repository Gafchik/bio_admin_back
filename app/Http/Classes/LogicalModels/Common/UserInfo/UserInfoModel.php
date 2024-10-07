<?php

namespace App\Http\Classes\LogicalModels\Common\UserInfo;

use App\Http\Classes\LogicalModels\Common\UserInfo\Exceptions\UserNotFoundException;
use App\Http\Classes\Structure\WalletsType;
use App\Models\MySql\Biodeposit\Activations;
use App\Models\MySql\Biodeposit\DemoBalance;
use App\Models\MySql\Biodeposit\DicCurrencies;
use App\Models\MySql\Biodeposit\Trees;
use App\Models\MySql\Biodeposit\UserInfo as UserInfoTable;
use App\Models\MySql\Biodeposit\Users;
use App\Models\MySql\Biodeposit\Wallets;
use App\Models\MySql\Biodeposit\Roles;
use App\Models\MySql\Biodeposit\RoleUsers;
use Illuminate\Database\Eloquent\Builder;

class UserInfoModel
{
    public function __construct(
        private Users $userModel,
        private DemoBalance $demoBalance,
        private DicCurrencies $dicCurrencies,
        private UserInfoTable $userInfo,
        private Wallets $wallets,
        private Trees $trees,
        private Roles $roles,
        private RoleUsers $roleUsers,
        private Activations $activations,
    ){}
    public function getUserInfo(string $fieldName, string $fieldValue): array
    {
        $user = $this->getBaseUserQuery()
            ->where('userModel.'.$fieldName,$fieldValue)
            ->select([
                'userModel.id',
                'userModel.uuid',
                'userModel.email',
                'userModel.permissions',
                'userModel.last_login',
                'userModel.referral_link',
                'userModel.created_at',
                'userModel.updated_at',
                'userModel.deleted_at',
                'userModel.deleted_email',
                'userModel.enable_2_fact',
//                'userModel.google2fa_secret',
                'userModel.is_active_user',
                'userInfo.first_name',
                'userInfo.last_name',
                'userInfo.phone',
                'userInfo.gender',
                'userInfo.birthday',
                'userInfo.avatar',
                'userInfo.created_at',
                'userInfo.updated_at',
                'userInfo.codePromo',
                'userInfo.level',
                'activations.completed as is_active',
            ])
            ->first()
            ?->toArray();

        if(empty($user)){
            throw new UserNotFoundException($fieldValue);
        }
        $user['demo_balance'] = $this->getDemoBalance($user['id']);
        $user['trees'] = $this->getUserTress($user['id']);
        $roles = $this->getUserRole($user['id']);
        $user['roles'] = [
          'role' => $roles['role_id'] ?? null,
          'permissions' => json_decode($roles['permissions'] ?? '[]',true),
        ];
        $wallets = $this->getWallets($user['id']);
        foreach ($wallets as $wallet){
            if($wallet['type'] === WalletsType::LIVE_PAY){
                $user['wallet_live_pay_id'] = $wallet['id'];
            }else if($wallet['type'] === WalletsType::BONUS){
                $user['wallet_bonus_id'] = $wallet['id'];
            }else if($wallet['type'] === WalletsType::FUTURES){
                $user['wallet_futures_id'] = $wallet['id'];
            }
        }
        $user['wallets'] = [...$wallets];
        return $user;
    }

    private function getBaseUserQuery(): Builder
    {
        return $this->userModel
            ->from($this->userModel->getTable(). ' as userModel')
            ->leftJoin($this->userInfo->getTable() . ' as userInfo',
                'userModel.id',
                '=',
                'userInfo.user_id'
            )
            ->leftJoin($this->activations->getTable() . ' as activations',
                'userModel.id',
                '=',
                'activations.user_id'
            );
    }
    private function getUserRole(int $userId): ?array
    {
        return $this->roleUsers
            ->from($this->roleUsers->getTable(). ' as roleUsers')
            ->leftJoin($this->roles->getTable() . ' as roles',
                'roles.id',
                '=',
                'roleUsers.role_id'
            )
            ->where('roleUsers.user_id',$userId)
            ->first()
            ?->toArray();
    }
    private function getDemoBalance(int $userId): array
    {
        return $this->demoBalance
            ->from($this->demoBalance->getTable(). ' as demoBalance')
            ->leftJoin($this->dicCurrencies->getTable() . ' as dicCurrencies',
                'demoBalance.currency_id',
                '=',
                'dicCurrencies.id'
            )
            ->select([
                'demoBalance.id',
                'demoBalance.balance',
                'dicCurrencies.name as currency_name',
            ])
            ->where('demoBalance.user_id',$userId)
            ->get()
            ->toArray();
    }
    private function getWallets(int $userId): array
    {
        return $this->wallets
            ->where('user_id',$userId)
            ->select([
                'id',
                'type',
                'balance'
            ])
            ->get()
            ->toArray();
    }
    private function getUserTress(int $userId): array
    {
        return $this->trees
            ->where('user_id',$userId)
            ->get()
            ->toArray();
    }
}
