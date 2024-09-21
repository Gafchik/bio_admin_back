<?php

namespace App\Http\Classes\LogicalModels\Withdraws\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class NotEnoughReservedMoneyException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Недостаточно зарезервированных денег',
        Lang::UKR => 'Недостатньо зарезервованих грошей',
        Lang::ENG => 'Not enough reserved money',
        Lang::GEO => 'არ არის საკმარისი რეზერვირებული ფული',
    ];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
}
