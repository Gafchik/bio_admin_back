<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Classes\LogicalModels\Contacts\Contacts;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\Contacts\AddContactsRequest;
use App\Http\Requests\Contacts\DeleteContactsRequest;
use App\Http\Requests\Contacts\EditContactsRequest;
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
    public function edit(EditContactsRequest $request): JsonResponse
    {
        $this->model->edit($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function add(AddContactsRequest $request): JsonResponse
    {
        $this->model->add($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function delete(DeleteContactsRequest $request): JsonResponse
    {
        $this->model->delete($request->validated());
        return $this->makeGoodResponse([]);
    }
}
