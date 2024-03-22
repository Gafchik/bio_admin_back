<?php

namespace App\Http\Controllers\BaseOnlyTextPages;

use App\Http\Classes\LogicalModels\BaseOnlyTextPages\BaseOnlyTextPages;
use App\Http\Controllers\BaseControllers\BaseController;
use App\Http\Requests\BaseOnlyTextPages\BaseOnlyTextPagesEditRequest;
use App\Http\Requests\BaseOnlyTextPages\BaseOnlyTextPagesGetRequest;
use Illuminate\Http\JsonResponse;

class BaseOnlyTextPagesController extends BaseController
{
    public function __construct(
        private BaseOnlyTextPages $model,
    )
    {
        parent::__construct();
    }
    public function get(BaseOnlyTextPagesGetRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->makeGoodResponse(
            $this->model->get($data['id'])
        );
    }
    public function edit(BaseOnlyTextPagesEditRequest $request): JsonResponse
    {
        $this->model->edit($request->validated());
        return $this->makeGoodResponse([]);
    }
}
