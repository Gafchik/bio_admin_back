<?php

namespace App\Http\Classes\LogicalModels\Gallery;

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
        $itemsToInsert = [];
        foreach ($data['items'] ?? [] as $item) {
            if(!empty($item['video']) || !empty($item['image'])){
                $itemsToInsert[] = $item;
            }
        }
//        dd($itemsToInsert);
        dd($data);
    }
}
