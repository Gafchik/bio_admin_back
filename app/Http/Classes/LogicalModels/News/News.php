<?php

namespace App\Http\Classes\LogicalModels\News;

//use App\Http\Classes\LogicalModels\News\Exceptions\NewsNotFoundException;

class News
{
    public function __construct(
        private NewsModel $model
    ){}

    public function getItems(int $page): array
    {
        return $this->model->getItems($page);
    }
    public function getAllCount(): int
    {
        return $this->model->getAllCount();
    }
    public function edit(array $data): void
    {
        $this->model->edit($data);
    }
    public function delete(int $id): void
    {
        $this->model->delete($id);
    }
    public function add(array $data): int
    {
        return $this->model->add($data);
    }
}
