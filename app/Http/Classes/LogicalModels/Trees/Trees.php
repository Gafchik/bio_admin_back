<?php

namespace App\Http\Classes\LogicalModels\Trees;

class Trees
{
    public function __construct(
        private TreesModel $model,
    ){}
    public function getPlantingDates(): array
    {
        return $this->model->getPlantingDates();
    }
    public function getTress(array $data): array
    {
        return $this->model->getTress($data);
    }
    public function editTrees(array $data): void
    {
        $this->model->editTrees($data);
    }
}
