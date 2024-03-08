<?php

namespace App\Http\Controllers\FAQ;

use App\Http\Classes\LogicalModels\FAQ\Faq;
use App\Http\Controllers\BaseControllers\BaseController;
use Illuminate\Http\JsonResponse;

class FaqController extends BaseController
{
    public function __construct(
        private Faq $model,
    )
    {
        parent::__construct();
    }
    public function getFaq(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getFaq()
        );
//        return $this->makeBadResponse(new test());
    }
}
