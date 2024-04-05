<?php

namespace App\Http\Classes\LogicalModels\Gallery\Exceptions;

use App\Exceptions\BaseExceptions\BaseException;
use App\Http\Classes\Structure\HttpStatus;
use App\Http\Classes\Structure\Lang;

class AlbumNotFoundException extends BaseException
{
    protected array $langArray = [
        Lang::RUS => 'Альбом не найден!',
        Lang::ENG => 'Album not found!',
    ];

    protected $code = HttpStatus::HTTP_UNPROCESSABLE_ENTITY;
}
