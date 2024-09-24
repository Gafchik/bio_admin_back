<?php

namespace App\Http\Classes\LogicalModels\Transactions;

use App\Http\Classes\Structure\CDateTime;
use App\Http\Facades\UserInfoFacade;
use App\Models\MySql\Biodeposit\Cooperative_translations;
use App\Models\MySql\Biodeposit\Cooperatives;
use App\Models\MySql\Biodeposit\Details_transactions;
use App\Models\MySql\Biodeposit\Dic_transactions_status;
use App\Models\MySql\Biodeposit\Dic_transactions_type;
use App\Models\MySql\Biodeposit\Fields;
use App\Models\MySql\Biodeposit\Locations;
use App\Models\MySql\Biodeposit\LocationTranslations;
use App\Models\MySql\Biodeposit\Order_details;
use App\Models\MySql\Biodeposit\Orders;
use App\Models\MySql\Biodeposit\Payments;
use App\Models\MySql\Biodeposit\Provinces;
use App\Models\MySql\Biodeposit\ProvinceTranslations;
use App\Models\MySql\Biodeposit\Transactions;
use App\Models\MySql\Biodeposit\Tree_type_translations;
use App\Models\MySql\Biodeposit\Trees;
use App\Models\MySql\Biodeposit\User_setting;
use App\Models\MySql\Biodeposit\UserInfo;
use App\Models\MySql\Biodeposit\Users;
use App\Models\MySql\Biodeposit\Wallets;
use Illuminate\Support\Facades\DB;

class TransactionsModel
{
    public function __construct(
        private Transactions $transactions,
        private Users $users,
        private Wallets $wallets,
        private UserInfo $userInfo,
        private Payments $payments,
        private Orders $orders,
        private Order_details $orderDetails,
        private Dic_transactions_status $transactionsStatus,
        private Dic_transactions_type $transactionsType,
        private Trees $trees,
        private Fields $fields,
        private Cooperatives $cooperatives,
        private Provinces $provinces,
        private ProvinceTranslations $provinceTranslations,
        private Locations $locations,
        private LocationTranslations $locationTranslations,
        private Cooperative_translations $cooperativeTranslations,
        private Tree_type_translations $tree_type_translations,
        private User_setting $userSetting,
        private Details_transactions $details_transactions,
    ){}

    public function getTypes(): array
    {
        return $this->transactionsType
            ->get()
            ->toArray();
    }
    public function getStatuses(): array
    {
        return $this->transactionsStatus
            ->get()
            ->toArray();
    }
    public function getTransaction(array $data): array
    {

        $detailsQuery = $this->details_transactions
            ->select('transaction_id', DB::raw('COUNT(*) as has_details'))
            ->groupBy('transaction_id');

        $query = $this->transactions
            ->from($this->transactions->getTable() . ' as t')
            ->leftJoin($this->wallets->getTable() . ' as w',
                'w.id',
                '=',
                't.wallet_id'
            )
            ->leftJoin($this->users->getTable() . ' as u',
                'u.id',
                '=',
                'w.user_id'
            )
            ->leftJoin($this->userInfo->getTable() . ' as ui',
                'u.id',
                '=',
                'ui.user_id'
            )
            ->leftJoin($this->payments->getTable() . ' as pay',
                'pay.id',
                '=',
                't.payment_service'
            )
            ->leftJoin($this->transactionsStatus->getTable() . ' as status',
                'status.id',
                '=',
                't.status'
            )
            ->leftJoin($this->transactionsType->getTable() . ' as type',
                'type.id',
                '=',
                't.type'
            )
            ->leftJoinSub($detailsQuery, 'dt', function($join) {
                $join->on('dt.transaction_id', '=', 't.id');
            })
            ->select([
                't.id',
                't.created_at',
                'u.email',
                'ui.phone',
                't.type as type_id',
                't.status as status_id',
                'type.name_rus as type',
                'status.name_rus as status',
                't.tree_count',
                DB::raw('ROUND(t.total / 100, 2) as total'),
                DB::raw('ROUND(t.amount / 100, 2) as amount'),
                DB::raw('ROUND(t.commission / 100, 2) as commission'),
                't.promocode',
                't.exchange_currency',
                't.exchange_rate',
                'pay.payment_system',
                DB::raw('IFNULL(dt.has_details, 0) as has_details') // Учитываем случаи, когда деталей транзакций нет
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

            // Фильтр по статусам
            if (!is_null($data['statuses'])) {
                $query->where('t.status', $data['statuses']);
            }

            // Фильтр по типу
            if (!is_null($data['type'])) {
                $query->where('t.type', $data['type']);
            }
        }

        // Выполнение запроса и сортировка
        return $query
            ->orderByDesc('t.id')
            ->get()
            ->toArray();
    }

    public function getDocumentData(array $data): array
    {
        $order = $this->orders
            ->where('transaction_id',$data['id'])
            ->first()
            ->toArray();

        $user =  $this->getUserInfo(id:$order['user_id']);
        $treeIds = $this->orderDetails
            ->where('order_id',$order['id'])
            ->pluck('tree_id')
            ->toArray();
        return [
            'order' => $order,
            'trees' => $this->getTreesInfoByDoc($treeIds),
            'user' => $user,
        ];
    }
    private function getTreesInfoByDoc(array $ids): array
    {
        return $this->trees
            ->from($this->trees->getTable(). ' as trees')
            ->leftJoin($this->fields->getTable() . ' as fields',
                'trees.field_id',
                '=',
                'fields.id'
            )
            ->leftJoin($this->tree_type_translations->getTable() . ' as tree_type_translations',
                function ($join) {
                    $join->on('tree_type_translations.tree_type_id', '=', 'trees.tree_type_id');
                    $join->where('tree_type_translations.locale','=','ru');
                }
            )
            ->leftJoin($this->cooperatives->getTable() . ' as cooperatives',
                'fields.cooperative_id',
                '=',
                'cooperatives.id'
            )
            ->leftJoin($this->cooperativeTranslations->getTable() . ' as cooperativeTranslations',
                function ($join) {
                    $join->on('cooperatives.id', '=', 'cooperativeTranslations.cooperative_id');
                    $join->where('cooperativeTranslations.locale','=','ru');
                }
            )
            ->leftJoin($this->provinces->getTable() . ' as provinces',
                'cooperatives.province_id',
                '=',
                'provinces.id'
            )
            ->leftJoin($this->provinceTranslations->getTable() . ' as provinceTranslations',
                function ($join) {
                    $join->on('provinces.id', '=', 'provinceTranslations.province_id');
                    $join->where('provinceTranslations.locale','=','ru');
                }
            )
            ->leftJoin($this->locations->getTable() . ' as locations',
                'provinces.location_id',
                '=',
                'locations.id'
            )
            ->leftJoin($this->locationTranslations->getTable() . ' as locationTranslations',
                function ($join) {
                    $join->on('locations.id', '=', 'locationTranslations.location_id');
                    $join->where('locationTranslations.locale','=','ru');
                }
            )
            ->select([
                'trees.uuid',                                       //айди дерева
                'trees.purchase_price',
                'trees.current_price',
                'trees.uuid',                                       //айди дерева
                'trees.coordinates',                                //кордитаны
                'trees.planting_date',                              //дата посадки
                'trees.initial_price',                              //цена
                'fields.cadastral_number',          //номер поля
                'cooperativeTranslations.name as cooperative_name',
                'tree_type_translations.title as tree_type',
            ])
            ->selectRaw("concat('(', locationTranslations.name, '), ', '(', provinceTranslations.name, ')') as location")
            ->whereIn('trees.id',$ids)
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
    public function getTransactionDetails(int $id): array
    {
        return $this->details_transactions
            ->from($this->details_transactions->getTable(). ' as dt')
            ->leftJoin($this->userInfo->getTable() . ' as userInfoFrom',
                'dt.from_user_id',
                '=',
                'userInfoFrom.user_id'
            )
            ->leftJoin($this->userInfo->getTable() . ' as userInfoTo',
                'dt.to_user_id',
                '=',
                'userInfoTo.user_id'
            )
            ->where('dt.transaction_id',$id)
            ->select([
                'dt.id',
                'dt.transaction_id',
                'dt.from_user_id',
                'userInfoFrom.first_name as from_first_name',
                'userInfoFrom.last_name as from_last_name',
                'dt.to_user_id',
                'userInfoTo.first_name as to_first_name',
                'userInfoTo.last_name as to_last_name',
                'dt.data',
                'dt.created_at',
                DB::RAW('ROUND(dt.total / 100, 2) as total'),
                DB::RAW('ROUND(dt.amount / 100, 2) as amount'),
                DB::RAW('ROUND(dt.commission / 100, 2) as commission'),
            ])
            ->get()
            ->toArray();
    }
}
