<?php

namespace App\Http\Classes\Core\BaseResponse;

use App\Http\Classes\Structure\HttpStatus;
use App\Exceptions\BaseExceptions\BaseException;
use Illuminate\Http\JsonResponse;

class BaseResponse implements BaseResponseInterface
{
    public function makeGoodResponse(array $data = []): JsonResponse
    {
        return response()
            ->json(
                [
                    'status' => HttpStatus::OK,
                    'data' => $data
                ],
                HttpStatus::OK
            );
    }

    public function makeBadResponse(BaseException $e): JsonResponse
    {
        return response()
            ->json(
                [
                    'status' => $e->getCode(),
                    'textError' => $e->getMessage()
                ],
                $e->getCode()
            );
    }
}
