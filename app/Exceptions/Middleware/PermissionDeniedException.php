<?php

namespace App\Exceptions\Middleware;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class PermissionDeniedException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Доступ запрещен!',
        Lang::ENG => 'Permission denied!',
    ];

    protected $code = HttpStatus::HTTP_FORBIDDEN;
}
