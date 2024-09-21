<?php

namespace App\Http\Classes\LogicalModels\Withdraws\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class WithdrawNotFoundException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Запрос на вывод не найден!',
        Lang::UKR => 'Запиту на вивід не знайдено!',
        Lang::ENG => 'Withdrawal request not found!',
        Lang::GEO => 'გატანის მოთხოვნა ვერ მოიძებნა!',
    ];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
}
