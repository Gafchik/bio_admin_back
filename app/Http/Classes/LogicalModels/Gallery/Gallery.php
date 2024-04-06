<?php

namespace App\Http\Classes\LogicalModels\Gallery;

use App\Http\Classes\Structure\Lang;

class Gallery
{
    public function __construct(
        private GalleryModel $model
    )
    {
    }

    public function getItems(): array
    {
        return $this->model->getItems();
    }
    public function getItemsAlbum(int $id): array
    {
        return $this->model->getItemsAlbum($id);
    }
    public function editItemsAlbum(array $data): void
    {
        $itemsToInsert = $this->getItemsToInsert($data);
        $this->model->editItemsAlbum($data,$itemsToInsert);
    }
    public function addItemsAlbum(array $data): void
    {
        $itemsToInsert = $this->getItemsToInsert($data);
        $this->model->addItemsAlbum($data,$itemsToInsert);
    }
    private function getItemsToInsert(array $data): array
    {
        $itemsToInsert = [];
        foreach ($data['items'] ?? [] as $item) {
            if(!empty($item['video']) || !empty($item['image'])){
                $itemsToInsert[] = $item;
            }
        }
        return $itemsToInsert;
    }
    public function deleteItemsAlbum(array $data): void
    {
        $this->model->deleteItemsAlbum($data['id']);
    }
}
