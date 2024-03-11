<?php

namespace App\Http\Classes\LogicalModels\Auth\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class Google2faCodeException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Неверный код!',
    ];

    protected $code = HttpStatus::HTTP_UNAUTHORIZED;
}
