<?php

namespace App\Http\Classes\LogicalModels\Transactions;

use App\Http\Facades\UserInfoFacade;

class Transactions
{
    public function __construct(
        private TransactionsModel $model
    ){}

    public function getTypes(): array
    {
        return $this->model->getTypes();
    }
    public function getStatuses(): array
    {
        return $this->model->getStatuses();
    }
    public function getTransaction(array $data): array
    {
        return $this->model->getTransaction($data);
    }
    public function getDocumentData(array $data): array
    {
        return $this->model->getDocumentData($data);
    }
    public function getTransactionDetails(int $id): array
    {
        $result = $this->model->getTransactionDetails($id);
        return array_map(function ($item) {
            $item['data'] = !!$item['data']
                ? json_decode($item['data'], true)
                : [];
            return $item;
        },$result);
    }
}
