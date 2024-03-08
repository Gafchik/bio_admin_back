<?php

namespace App\Http\Classes\Structure;

final class CurrencyName
{
    public const USD = [
        'id' => 1,
        'ccy' => 840,
        'name' => 'USD'
    ];
    public const UAH = [
        'id' => 2,
        'ccy' => 980,
        'name' => 'UAH'
    ];

    public const ARRAY_CURRENCY = [
        self::UAH,
        self::USD,
    ];
}
