<?php

namespace App\Http\Controllers\FAQ;

use App\Http\Classes\LogicalModels\FAQ\Faq;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\FAQ\AddCategoryRequest;
use App\Http\Requests\FAQ\ChangeCategoryRequest;
use App\Http\Requests\FAQ\DeleteCategoryRequest;
use Illuminate\Http\JsonResponse;

class FaqController extends BaseController
{
    public function __construct(
        private Faq $model,
    )
    {
        parent::__construct();
    }
    public function getFaq()
    {
        return $this->makeGoodResponse(
            $this->model->getFaq()
        );
    }

    public function getFaqCategory(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getFaqCategory()
        );
    }
    public function getFaqQuestion(): JsonResponse
    {
        return $this->makeGoodResponse(
            $this->model->getFaqQuestion()
        );
    }
    public function changeCategory(ChangeCategoryRequest $request): JsonResponse
    {
        $this->model->changeCategory($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function addCategory(AddCategoryRequest $request): JsonResponse
    {
        $this->model->addCategory($request->validated());
        return $this->makeGoodResponse([]);
    }
    public function deleteCategory(DeleteCategoryRequest $request)
    {
        $this->model->deleteCategory($request->validated());
        return $this->makeGoodResponse([]);
    }
}
