<?php

namespace App\Http\Classes\Core\BaseResponse;

use App\Exceptions\BaseExceptions\BaseException;
use Illuminate\Http\JsonResponse;

interface BaseResponseInterface
{
    public function makeGoodResponse(array $data): JsonResponse;
    public function makeBadResponse(BaseException $e): JsonResponse;
}
