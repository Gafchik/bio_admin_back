<?php

namespace App\Http\Classes\LogicalModels\Withdraws;

use App\Http\Classes\Structure\WithdrawStatuses;
use App\Http\Facades\UserInfoFacade;

class Withdraws
{
    public function __construct(
        private WithdrawsModel $model,
    ){}

    public function getWithdraws(): array
    {
        return $this->model->getWithdraws();
    }
    public function editWithdraws(array $data): void
    {
        $data['status'] === WithdrawStatuses::CONFIRMED
            ? $this->model->confirmedHandler($data)
            : $this->model->canceledHandler($data);
    }
    public function infoWithdraws(array $data): array
    {
        $currentWithdraw = $this->model->getCurrentWithdraws($data['id']);
        $user = UserInfoFacade::getUserInfo('id',$currentWithdraw['user_id']);
        return $this->model->getTransactionInfo($user['wallet_live_pay_id']);
    }
}
