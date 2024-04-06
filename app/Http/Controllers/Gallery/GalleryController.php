<?php

namespace App\Http\Controllers\Gallery;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\Gallery\Gallery;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\Gallery\AddAlbumsRequest;
use App\Http\Requests\Gallery\AlbumIdRequest;
use App\Http\Requests\Gallery\EditAlbumsRequest;
use Illuminate\Http\JsonResponse;

class GalleryController extends BaseController
{
    public function __construct(
        private Gallery $model,
    )
    {
        parent::__construct();
    }
    public function getItems(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getItems(),
        );
    }
    public function getItemsAlbum(AlbumIdRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $album = $this->model->getItemsAlbum($data['id']);
            return $this->makeGoodResponse($album);
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
    }
    public function editItemsAlbum(EditAlbumsRequest $request): JsonResponse
    {
        $this->model->editItemsAlbum($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function addItemsAlbum(AddAlbumsRequest $request): JsonResponse
    {
        $this->model->addItemsAlbum($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function deleteItemsAlbum(AlbumIdRequest $request): JsonResponse
    {
        $this->model->deleteItemsAlbum($request->validated());
        return $this->makeGoodResponse([]);
    }
}
