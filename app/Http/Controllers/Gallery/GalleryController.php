<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Classes\LogicalModels\Gallery\Gallery;
use App\Http\Controllers\BaseControllers\BaseController;
use Illuminate\Http\JsonResponse;

class GalleryController extends BaseController
{
    public function __construct(
        private Gallery $model,
    )
    {
        parent::__construct();
    }
    public function getItems(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getItems(),
        );
    }
}
