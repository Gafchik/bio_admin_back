<?php

namespace App\Http\Controllers\Roles;

use App\Http\Classes\LogicalModels\Roles\Roles;
use App\Http\Controllers\BaseControllers\BaseController;
use \App\Models\MySql\Biodeposit\Roles as RolesTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends BaseController
{
    public function __construct(
        private Roles $model
    )
    {
        parent::__construct();
    }
    public function getRoles(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getRoles()
        );
    }
    public function editRoles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . RolesTable::class . ',id'],
            'permission' => ['required', 'json'],
        ]);
        $this->model->editRoles($validated);
        return $this->makeGoodResponse([]);
    }
    public function deleteRoles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'int', 'exists:' . RolesTable::class . ',id'],
        ]);
        $this->model->deleteRoles($validated);
        return $this->makeGoodResponse([]);
    }
    public function addRoles(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'unique:' . RolesTable::class . ',slug'],
            'name' => ['required', 'string', 'unique:' . RolesTable::class . ',name'],
            'permission' => ['required', 'json'],
        ],[
            // Кастомные сообщения для валидации
            'key.unique' => 'Роль с таким ключом уже существует. Пожалуйста, выберите другой ключ.',
            'name.unique' => 'Роль с таким именем уже существует. Пожалуйста, выберите другое имя.',
        ]);
        $this->model->addRoles($validated);
        return $this->makeGoodResponse([]);
    }
}
