<?php

namespace App\Http\Classes\LogicalModels\TreeStore;

use App\Http\Classes\Structure\CDateTime;
use App\Models\MySql\Biodeposit\Trees;
use App\Models\MySql\Biodeposit\Trees_on_sale;
use App\Models\MySql\Biodeposit\User_setting;
use App\Models\MySql\Biodeposit\UserInfo;
use App\Models\MySql\Biodeposit\Users;
use Illuminate\Support\Facades\DB;

class TreeStoreModel
{
    public function __construct(
        private Trees_on_sale $trees_on_sale,
        private Users $users,
        private UserInfo $userInfo,
        private Trees $trees,
        private User_setting $userSetting
    ){}

    public function getTreeStore(array $data): array
    {

        $query = $this->trees_on_sale
            ->from($this->trees_on_sale->getTable() . ' as t')
            ->leftJoin($this->trees->getTable() . ' as tr',
                't.tree_id',
                '=',
                'tr.id'
            )
            ->leftJoin($this->users->getTable() . ' as u',
                'u.id',
                '=',
                'tr.user_id' // Получаем user_id из таблицы trees
            )
            ->leftJoin($this->userInfo->getTable() . ' as ui',
                'u.id',
                '=',
                'ui.user_id'
            )
            ->select([
                't.id',
                't.created_at',
                'u.email',          // Извлекаем email из таблицы users
                't.commission',
                'tr.uuid',          // Извлекаем uuid из таблицы trees
                DB::raw('ROUND(t.price / 100, 2) as amount')
            ]);



        // Фильтрация по id
        if (!empty($data['id'])) {
            $query->where('t.id', $data['id']);
        } else {
            // Фильтрация по дате или email, если другие параметры не заданы
            if (empty($data['dateFromTo']['from']) || empty($data['dateFromTo']['to']) || empty($data['email'])) {
                $query->limit(500);
            }

            // Фильтр по дате начала
            if (!empty($data['dateFromTo']['from'])) {
                $query->where('t.created_at', '>=', $data['dateFromTo']['from']);
            }

            // Фильтр по дате окончания
            if (!empty($data['dateFromTo']['to'])) {
                $data['dateFromTo']['to'] = CDateTime::getDateModified($data['dateFromTo']['to'], '+1 day');
                $query->where('t.created_at', '<', $data['dateFromTo']['to']);
            }

            // Фильтр по email
            if (!is_null($data['email'])) {
                $query->where('u.email', $data['email']);
            }

            // Фильтр по годам
            if (!empty($data['year'])) {
                $query->whereRaw('YEAR(tr.planting_date) = ?', [$data['year']]);
            }

        }

        // Выполнение запроса и сортировка
        return $query
            ->orderByDesc('t.id')
            ->get()
            ->toArray();
    }

    public function getUserInfo(int $id): ?array
    {
        $result = $this->users
            ->from($this->users->getTable(). ' as userModel')
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
            ->where('userModel.id',$id)
            ->select([
                'userModel.id',
                'userModel.email',
                'userSetting.locale',
                'userModel.permissions',
                'userModel.is_active_user',
                'userInfo.first_name as lastName',
                'userInfo.last_name as firstName',
                'userInfo.phone',
                'userSetting.locale',
                'userSetting.promocode',
                'userInfo.level',
                'userModel.google2fa_secret as secret_key',
            ])
            ->selectRaw('!ISNULL(userModel.google2fa_secret) as has_2fa_code')
            ->first()
            ?->toArray();
        return $result;
    }
}
