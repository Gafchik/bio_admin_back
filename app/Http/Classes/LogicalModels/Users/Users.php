<?php

namespace App\Http\Classes\LogicalModels\Users;

class Users
{
    public function __construct(
        private UsersModel $model,
    ){}

    public function getUsers(): array
    {
        return $this->model->getUsers();
    }
    public function getUsersReferals(int $id): array
    {
        return $this->model->getUsersReferals($id);
    }
    public function deleteUsers(array $data): void
    {
        $this->model->deleteUsers($data);
    }
    public function editPersonalData(array $data): void
    {
        $this->model->editPersonalData($data);
    }
    public function editRoles(array $data): void
    {
        $this->model->editRoles($data);
    }
}
