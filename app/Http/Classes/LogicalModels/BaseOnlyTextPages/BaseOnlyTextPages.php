<?php

namespace App\Http\Classes\LogicalModels\BaseOnlyTextPages;

class BaseOnlyTextPages
{
    public function __construct(
        private BaseOnlyTextPagesModel $model
    ){}
    public function get(int $id): array
    {
        return $this->model->get($id);
    }
    public function edit(array $data): void
    {
        $this->model->edit($data);
    }
}
