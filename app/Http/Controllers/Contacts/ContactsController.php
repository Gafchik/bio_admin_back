<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Classes\LogicalModels\Contacts\Contacts;
use App\Http\Controllers\BaseControllers\BaseController;
use Illuminate\Http\JsonResponse;

class ContactsController extends BaseController
{
    public function __construct(
        private Contacts $model,
    )
    {
        parent::__construct();
    }

    public function getContactsInfo(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getContactsInfo()
        );
    }
}
