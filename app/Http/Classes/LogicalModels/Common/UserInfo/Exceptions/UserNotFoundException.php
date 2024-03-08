<?php

namespace App\Http\Classes\LogicalModels\Common\UserInfo\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class UserNotFoundException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Информация о пользователе %s не найдена!',
        Lang::UKR => 'Інформація про користувача %s не знайдена!',
        Lang::ENG => 'User information %s not found!',
        Lang::GEO => 'მომხმარებლის ინფორმაცია %s ვერ მოიძებნა!',
    ];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
}
