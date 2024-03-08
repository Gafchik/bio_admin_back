<?php

namespace App\Http\Facades;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Core\BaseResponse\BaseResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse makeGoodResponse(array $data = []);
 * @method static makeBadResponse(BaseException $e);
 * @see BaseResponseInterface
 */
class ResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'base_response_facade';
    }
}
