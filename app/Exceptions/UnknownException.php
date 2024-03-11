<?php

namespace App\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class UnknownException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Не извесная ошибка %s',
    ];

    protected $code = HttpStatus::HTTP_INTERNAL_SERVER_ERROR;
}
