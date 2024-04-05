<?php

namespace App\Http\Controllers\News;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\LogicalModels\News\News;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\News\AddNewsRequest;
use App\Http\Requests\News\DeleteNewsRequest;
use App\Http\Requests\News\EditNewsRequest;
use App\Http\Requests\News\NewsCardRequest;
use Illuminate\Http\JsonResponse;

class NewsController extends BaseController
{
    public function __construct(
        private News $model,
    )
    {
        parent::__construct();
    }
    public function getItems(NewsCardRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->makeGoodResponse([
            'items' => $this->model->getItems($data['page']),
            'allCount' => $this->model->getAllCount(),
        ]);
    }
    public function edit(EditNewsRequest $request): JsonResponse
    {
        try {
            $this->model->edit($request->validated());
            return $this->makeGoodResponse([]);
        }catch (BaseException $e){
            return $this->makeBadResponse($e);
        }
    }
    public function delete(DeleteNewsRequest $request)
    {
        $data = $request->validated();
        $this->model->delete($data['id']);
        return $this->makeGoodResponse([]);
    }
    public function add(AddNewsRequest $request)
    {
        $id = $this->model->add($request->validated());
        return $this->makeGoodResponse(['id' => $id]);
    }
}
