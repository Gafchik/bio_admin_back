<?php

namespace App\Http\Controllers\Trees;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Trees\Trees;
use App\Http\Classes\Structure\CDateTime;
use App\Http\Controllers\BaseControllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\MySql\Biodeposit\Trees as TreesTable;
use App\Models\MySql\Biodeposit\Users as UsersTable;

class TreesController  extends BaseController
{
    public function __construct(
        private Trees $model,
    )
    {
        parent::__construct();
    }

    public function getPlantingDates(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getPlantingDates()
        );
    }
    public function getTress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plantingDate' => ['nullable','date_format:'.CDateTime::DATE_YEAR],
            'email' => ['nullable','email'],
            'uuid' => ['nullable','exists:' . TreesTable::class . ',uuid'],
        ]);

        return $this->makeGoodResponse(
            $this->model->getTress($validated)
        );
    }
    public function editTrees(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required','exists:' . TreesTable::class . ',id'],
            'owner_mail' => ['required','email','exists:' . UsersTable::class . ',email'],
            'sale_frozen_to' => ['nullable','date_format:'.CDateTime::DATE_FORMAT_PICKER],
            'dividend_frozen_to' => ['nullable','date_format:'.CDateTime::DATE_FORMAT_PICKER],
        ],[
            'owner_mail.exists' => 'Такого пользователя не существует!',
            'id.exists' => 'Такого дерева не существует!',
        ]);
        try {
            $this->model->editTrees($validated);
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
        return $this->makeGoodResponse([]);
    }
}
