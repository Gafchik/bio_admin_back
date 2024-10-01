<?php

namespace App\Http\Classes\LogicalModels\Roles;

class Roles
{
    public function __construct(
        private RolesModel $model
    ){}
    public function getRoles(): array
    {
        return $this->model->getRoles();
    }
    public function editRoles(array $data): void
    {
        $this->model->editRoles($data);
    }
    public function addRoles(array $data): void
    {
        $this->model->addRoles($data);
    }
    public function deleteRoles(array $data): void
    {
        $this->model->deleteRoles($data);
    }
}
