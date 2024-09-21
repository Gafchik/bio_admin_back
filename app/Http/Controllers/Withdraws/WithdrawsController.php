<?php

namespace App\Http\Controllers\Withdraws;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Withdraws\Withdraws;
use App\Http\Classes\Structure\WithdrawStatuses;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Models\MySql\Biodeposit\Withdraws as WithdrawsTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawsController extends BaseController
{
    public function __construct(
        private Withdraws $model
    )
    {
        parent::__construct();
    }
    public function getWithdraws(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getWithdraws()
        );
    }
    public function editWithdraws(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . WithdrawsTable::class . ',id'],
            'status' => ['required', 'int', 'in:'. implode(',', [WithdrawStatuses::CONFIRMED,WithdrawStatuses::CANCELED])],
        ]);
        try {
            $this->model->editWithdraws($validated);
            return $this->makeGoodResponse([]);
        }catch (BaseException $exception){
            return $this->makeBadResponse($exception);
        }
    }
    public function infoWithdraws(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . WithdrawsTable::class . ',id'],
        ]);
        return $this->makeGoodResponse(
            $this->model->infoWithdraws($validated)
        );
    }
}
