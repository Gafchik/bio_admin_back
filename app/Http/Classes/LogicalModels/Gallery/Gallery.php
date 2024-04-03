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
}
