<?php

namespace App\Http\Classes\LogicalModels\Roles;
use App\Http\Classes\Structure\CDateTime;
use App\Models\MySql\Biodeposit\Roles;

class RolesModel
{
    public function __construct(
        private Roles $role
    ){}

    public function getRoles(): array
    {
        return $this->role
            ->orderBy('id')
            ->get()
            ->toArray();
    }
    public function editRoles(array $data): void
    {
        $this->role
            ->where('id', $data['id'])
            ->update([
                'permissions' => $data['permission'],
            ]);
    }
    public function deleteRoles(array $data): void
    {
        $this->role
            ->where('id', $data['id'])
            ->delete();
    }
    public function addRoles(array $data): void
    {
        $this->role->insert([
            'slug' => $data['key'],
            'name' => $data['name'],
            'permissions' => $data['permission'],
            'created_at' => CDateTime::getCurrentDate(),
            'updated_at' => CDateTime::getCurrentDate(),
        ]);
    }
}
