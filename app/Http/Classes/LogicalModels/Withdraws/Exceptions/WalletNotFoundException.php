<?php

namespace App\Http\Classes\LogicalModels\Withdraws\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class WalletNotFoundException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Кошелек для вывода не найден!',
        Lang::UKR => 'Гаманець для виведення не знайдено!',
        Lang::ENG => 'Withdrawal wallet not found!',
        Lang::GEO => 'გასატანი საფულე ვერ მოიძებნა!',
    ];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
}
