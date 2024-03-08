<?php

namespace App\Exceptions\BaseExceptions;

use App\Http\Classes\Structure\{
    HttpStatus,
    Lang,
};
use Exception;
use Throwable;

class BaseException extends Exception
{
    const DEF_ERROR = 'An unspecified error';
    const DEF_LANG_ARR = [
        Lang::RUS => 'Неопознаная ошибка',
        Lang::UKR => 'Невідома помилка',
        Lang::ENG => 'Unidentified error',
        Lang::GEO => 'ამოუცნობი შეცდომა',
    ];
    protected array $langArray = self::DEF_LANG_ARR;
    protected string $lang;

    protected $code = HttpStatus::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(...$args)
    {
        $app = app();
        $this->lang =  $app->getLocale();
        $this->formattedString(...$args);
        $messageAll = $this->langArray[$this->lang] ?? self::DEF_ERROR;
        parent::__construct($messageAll, $this->code, null);
    }

    protected function formattedString()
    {
        $prepareData = [];
        if (func_get_args() > 0) {
            foreach (func_get_args() as $index => $param) {
                $prepareData[] = $param;
            }
            foreach ($this->langArray as $index => &$value) {
                try {
                    $value = sprintf($value, ...$prepareData);
                } catch (Throwable $exception) {}
            }
        }
    }
}
