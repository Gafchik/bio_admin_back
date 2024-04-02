<?php

namespace App\Exceptions\BaseExceptions\Core;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class UnauthorizedJWTException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Закончилось время жизни сессии, Обновите страницу и авторизируйтесь',
        Lang::UKR => 'Закінчився час життя сесії, Оновіть сторінку та авторизуйтесь',
        Lang::ENG => 'Session lifetime has expired, Refresh the page and log in',
        Lang::GEO => 'სესიის ვადა ამოიწურა, განაახლეთ გვერდი და შედით სისტემაში',
    ];

    protected $code = HttpStatus::HTTP_UNAUTHORIZED;
}
