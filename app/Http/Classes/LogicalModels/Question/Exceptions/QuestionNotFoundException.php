<?php

namespace App\Http\Classes\LogicalModels\Question\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class QuestionNotFoundException extends BaseException
{
    protected array $langArray = [
    Lang::RUS => 'Вопрос не найден!',
    Lang::UKR => 'Питання не знайдено!',
    Lang::ENG => 'Question not found!',
    Lang::GEO => 'კითხვა ვერ მოიძებნა!',
];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;

}
