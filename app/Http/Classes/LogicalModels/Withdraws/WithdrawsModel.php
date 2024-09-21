<?php

namespace App\Http\Classes\LogicalModels\Withdraws;

use App\Http\Classes\LogicalModels\Withdraws\Exceptions\NotEnoughReservedMoneyException;
use App\Http\Classes\LogicalModels\Withdraws\Exceptions\WalletNotFoundException;
use App\Http\Classes\LogicalModels\Withdraws\Exceptions\WithdrawNotFoundException;
use App\Http\Classes\Structure\CDateTime;
use App\Http\Classes\Structure\TransactionStatus;
use App\Http\Classes\Structure\TransactionTypes;
use App\Http\Classes\Structure\WithdrawStatuses;
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
use App\Models\MySql\Biodeposit\Tree_type_translations;
use App\Models\MySql\Biodeposit\Trees;
use App\Models\MySql\Biodeposit\User_setting;
use App\Models\MySql\Biodeposit\UserInfo;
use App\Models\MySql\Biodeposit\Users;
use App\Models\MySql\Biodeposit\Wallets;
use App\Models\MySql\Biodeposit\Withdraws;
use App\Models\MySql\Biodeposit\Transactions;
use Illuminate\Support\Facades\DB;

class WithdrawsModel
{
    public function __construct(
        private Withdraws $withdraws,
        private Wallets $wallets,
        private Transactions $transactions,
        private Users $users,
        private UserInfo $userInfo,
        private Payments $payments,
        private Dic_transactions_status $transactionsStatus,
        private Dic_transactions_type $transactionsType,
    ){}

    public function getWithdraws(): array
    {
        return $this->withdraws
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }

    public function confirmedHandler(array $data): void
    {
        $currentWithdraw = $this->getCurrentWithdraws($data['id']);
        $user = UserInfoFacade::getUserInfo('id',$currentWithdraw['user_id']);
        $wallet = $this->getWallet($user['wallet_live_pay_id']);
        $this->checkReservedBalance($wallet, $currentWithdraw);
        $this->withdraws->getConnection()
            ->transaction(function () use ($data,$currentWithdraw,$user,$wallet) {
                $this->withdraws
                    ->where('id', $data['id'])
                    ->update([
                        'status' => WithdrawStatuses::CONFIRMED,
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                $this->wallets
                    ->where('id', $wallet['id'])
                    ->update([
                        'reserved' => $wallet['reserved'] - $currentWithdraw['amount'],
                    ]);
                $this->transactions->insert([
                    'wallet_id' => $wallet['id'],
                    'type' => TransactionTypes::WITHDRAWAL_OF_MONEY,
                    'amount' => $currentWithdraw['amount'],
                    'commission' => 0,
                    'total' => $currentWithdraw['amount'],
                    'tree_count' => 0,
                    'status' => TransactionStatus::SUCCESSFUL,
                    'created_at' => CDateTime::getCurrentDate(),
                    'updated_at' => CDateTime::getCurrentDate(),
                ]);
            });
    }
    public function canceledHandler(array $data): void
    {
        $currentWithdraw = $this->getCurrentWithdraws($data['id']);
        $user = UserInfoFacade::getUserInfo('id',$currentWithdraw['user_id']);
        $wallet = $this->getWallet($user['wallet_live_pay_id']);
        $this->checkReservedBalance($wallet, $currentWithdraw);
        $this->withdraws->getConnection()
            ->transaction(function () use ($data,$currentWithdraw,$user,$wallet) {
                $this->withdraws
                    ->where('id', $data['id'])
                    ->update([
                        'status' => WithdrawStatuses::CANCELED,
                        'updated_at' => CDateTime::getCurrentDate(),
                    ]);
                $this->wallets
                    ->where('id', $wallet['id'])
                    ->update([
                        'balance' => $wallet['balance'] + $currentWithdraw['amount'],
                        'reserved' => $wallet['reserved'] - $currentWithdraw['amount'],
                    ]);
            });
    }
    public function getCurrentWithdraws(int $id): array
    {
        $result = $this->withdraws
            ->where('id',$id)
            ->first()
            ?->toArray();
        if(is_null($result)){
            throw new WithdrawNotFoundException();
        }
        return $result;
    }
    private function getWallet(int $id): array
    {
        $result = $this->wallets
            ->where('id',$id)
            ->first()
            ?->toArray();
        if(is_null($result)){
            throw new WalletNotFoundException();
        }
        return $result;
    }
    private function checkReservedBalance(array $wallet, array $currentWithdraw): void
    {
        if($wallet['reserved'] < $currentWithdraw['amount']){
            throw new NotEnoughReservedMoneyException();
        }
    }
    public function getTransactionInfo(int $walletId): array
    {
        return $this->transactions
            ->from($this->transactions->getTable(). ' as t')
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
                DB::RAW('ROUND(t.total / 100, 2) as total'),
                DB::RAW('ROUND(t.amount / 100, 2) as amount'),
                DB::RAW('ROUND(t.commission / 100, 2) as commission'),
                't.promocode',
                't.exchange_currency',
                't.exchange_rate',
                'pay.payment_system',
            ])
            ->where('t.wallet_id',$walletId)
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
}
