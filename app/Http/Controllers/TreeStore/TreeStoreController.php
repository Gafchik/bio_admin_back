<?php

namespace App\Http\Controllers\TreeStore;

use App\Http\Classes\LogicalModels\TreeStore\TreeStore;
use App\Http\Controllers\BaseControllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TreeStoreController extends BaseController
{
    public function __construct(
        private TreeStore $model,
    )
    {
        parent::__construct();
    }
    public function getPlantingDatesTreeStore(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getPlantingDatesTreeStore()
        );
    }
    public function getTreeStore(Request $request): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getTreeStore($request->toArray())
        );
    }


}
