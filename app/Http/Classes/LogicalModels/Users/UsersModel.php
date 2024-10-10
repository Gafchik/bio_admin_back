<?php

namespace App\Http\Classes\LogicalModels\Users;

use App\Http\Classes\Helpers\PasswordHashHelper;
use App\Http\Classes\Helpers\TransformArray\TransformArrayHelper;
use App\Http\Classes\Structure\CDateTime;
use App\Http\Facades\UserInfoFacade;
use App\Models\MySql\Biodeposit\{
    User_setting,
    UserInfo as UserInfoTable,
    Users as UserTable,
    Trees,
    Activations,
    Wallets,
    RoleUsers,
    Referrals,
};

class UsersModel
{
    public function __construct(
        private UserTable $userModel,
        private UserInfoTable $userInfo,
        private User_setting $userSetting,
        private Trees $trees,
        private Activations $activations,
        private Wallets $wallets,
        private RoleUsers $roleUsers,
        private Referrals $referrals,
    ){}

    public function getUsers(): array
    {
        return $this->userModel
            ->from($this->userModel->getTable() . ' as u')
            ->leftJoin($this->userInfo->getTable() . ' as ui',
                'u.id',
                '=',
                'ui.user_id'
            )
            ->leftJoin($this->userSetting->getTable() . ' as us',
                'u.id',
                '=',
                'us.user_id'
            )
            ->leftJoin($this->activations->getTable() . ' as activations',
                'u.id',
                '=',
                'activations.user_id'
            )
            ->leftJoinSub(
                $this->trees
                    ->select(['user_id'])
                    ->selectRaw('count(*) as count_trees')
                    ->groupBy('user_id'),
                'trees',
                'u.id',
                '=',
                'trees.user_id'
            )
            ->select([
                'u.id',
                'u.email',
                'ui.phone',
                'activations.completed as is_active',
                'ui.codePromo as code',
                'us.promocode',
                'u.created_at'
            ])
            ->selectRaw("CONCAT(ui.last_name,' ',ui.first_name) as fio")
            ->selectRaw("COALESCE(trees.count_trees, 0) as count_trees")
            ->orderByDesc('u.id')
            ->get()
            ->toArray();
    }
    public function deleteUsers(array $data): void
    {
        $this->userModel->getConnection()
            ->transaction(function () use ($data) {
                $this->wallets->where('user_id', $data['id'])->delete();
                $this->activations->where('user_id', $data['id'])->delete();
                $this->userSetting->where('user_id', $data['id'])->delete();
                $this->userInfo->where('user_id', $data['id'])->delete();
                $this->userModel->where('id', $data['id'])->delete();
            });
    }
    public function editPersonalData(array $data): void
    {
        $this->userModel->getConnection()->transaction(function () use ($data) {
            $this->userInfo
                ->where('user_id', $data['id'])
                ->update([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'phone' => $data['phone'],
                    'gender' => $data['gender'],
                ]);
            $modelData = [
                'email' => $data['email']
            ];
            if(isset($data['newPassword'])){
                $modelData['password'] = PasswordHashHelper::generatePasswordHash($data['newPassword']);
            }
            $this->userModel
                ->where('id', $data['id'])
                ->update($modelData);
            $this->activations
                ->where('user_id', $data['id'])
                ->update(['completed' => (int)$data['is_active']]);
        });
    }
    public function editRoles(array $data): void
    {
        $userId = $data['id'];
        $roleForAdd = array_column(TransformArrayHelper::callbackSearchAllInArray(
            array: $data['roles'],
            callback: fn($value) => $value['action'] === 'add'
        ),'id');
        $insertData = [];
        foreach ($roleForAdd as $role) {
            $insertData[] = [
                'user_id' => $userId,
                'role_id' => $role,
                'created_at' => CDateTime::getCurrentDate(),
                'updated_at' => CDateTime::getCurrentDate(),
            ];
        }
        $roleForDelete = array_column(TransformArrayHelper::callbackSearchAllInArray(
            array: $data['roles'],
            callback: fn($value) => $value['action'] === 'delete'
        ),'id');

        $this->roleUsers->getConnection()->transaction(function () use ($userId, $insertData, $roleForDelete) {
            $this->roleUsers->insert($insertData);
            $this->roleUsers
                ->where('user_id', $userId)
                ->whereIn('role_id', $roleForDelete)
                ->delete();
        });
    }
    public function getUsersReferals(int $id): array
    {
        return $this->referrals
            ->where('user_id',$id)
            ->get()
            ->toArray();
    }
    public function editSetting(array $data)
    {
        $userId = $data['id'];
        $user = UserInfoFacade::getUserInfo('id',$userId);
        $this->userModel->getConnection()->transaction(function () use ($user,$data) {
            $this->updateWallets($user,$data);
            $this->updateUserSetting($user,$data);
        });
    }
    private function updateUserSetting(array $user,array $data): void
    {
        $this->userSetting
            ->where('user_id', $user['id'])
            ->update([
                'promocode' => $data['promocode'],
                'promocode_discount' => $data['promocode_discount'],
                'promocode_bonus' => $data['promocode_bonus'],
                'promocode_wallet' => $data['promocode_wallet'],
                'promocode_multiple' => $data['promocode_multiple'],
                'promocode_area' => json_encode($data['promocode_area']),
                'promocode_tree_min' => $data['promocode_tree_min'],
                'promocode_tree_max' => $data['promocode_tree_max'],
                'max_number_trees_for_sale' => $data['max_number_trees_for_sale'],
                'shop_commission' => $data['shop_commission'],
                'gift_commission' => $data['gift_commission'],
                'shop_commission_first_sale' => $data['shop_commission_first_sale'],
                'shop_commission_gift_sale' => $data['shop_commission_gift_sale'],
            ]);
    }
    private function updateWallets(array $user,array $data): void
    {
        $this->wallets->where('id', $user['wallet_live_pay_id'])->update(['balance' => $data['live_wallet_balance']]);
        $this->wallets->where('id', $user['wallet_bonus_id'])->update(['balance' => $data['bonus_wallet_balance']]);
        $this->wallets->where('id', $user['wallet_futures_id'])->update(['balance' => $data['futures_wallet_balance']]);
    }
}
