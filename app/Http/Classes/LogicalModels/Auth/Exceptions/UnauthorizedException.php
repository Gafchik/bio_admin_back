<?php

namespace App\Http\Classes\LogicalModels\Auth\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class UnauthorizedException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Неверный Email или пароль!',
    ];

    protected $code = HttpStatus::HTTP_FORBIDDEN;
}
