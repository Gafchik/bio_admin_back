<?php

namespace App\Exceptions\BaseExceptions\Core;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\{
    HttpStatus,
    Lang,
};

class BaseValidationException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Ошибка валидации: %s',
        Lang::UKR => 'Помилка валідації: %s',
        Lang::ENG => 'Validation error: %s',
        Lang::GEO => 'ვალიდაციის შეცდომა: %s',
    ];

    protected $code = HttpStatus::HTTP_BAD_REQUEST;
}
