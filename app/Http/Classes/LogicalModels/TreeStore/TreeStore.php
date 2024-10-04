<?php

namespace App\Http\Classes\LogicalModels\TreeStore;

use App\Http\Facades\UserInfoFacade;

class TreeStore
{
    public function __construct(
        private TreeStoreModel $model
    ){}

    public function getTreeStore(array $data): array
    {
        return $this->model->getTreeStore($data);
    }

}
