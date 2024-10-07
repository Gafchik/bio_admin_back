<?php

namespace App\Http\Controllers\Users;

use App\Http\Classes\LogicalModels\Users\Users;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Facades\UserInfoFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\MySql\Biodeposit\Users as UsersTable;

class UsersController extends BaseController
{
    public function __construct(
        private Users $model
    )
    {
        parent::__construct();
    }

    public function getUsers(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getUsers()
        );
    }
    public function deleteUsers(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required','exists:' . UsersTable::class . ',id'],
        ]);
        $this->model->deleteUsers($validated);
        return $this->makeGoodResponse([]);
    }
    public function getUserById(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required','exists:' . UsersTable::class . ',id'],
        ]);
        return $this->makeGoodResponse(
            UserInfoFacade::getUserInfo('id',$validated['id'])
        );
    }
    public function editPersonalData(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required','exists:' . UsersTable::class . ',id'],
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'email' => ['required','email'],
            'phone' => ['required','string'],
            'gender' => ['required','string'],
            'is_active' => ['required','boolean'],
            'newPassword' => ['nullable','string','min:8'],
        ]);
        $this->model->editPersonalData($validated);
        return $this->makeGoodResponse([]);
    }
}





