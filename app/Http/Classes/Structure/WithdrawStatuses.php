<?php

namespace App\Http\Classes\Structure;

final class WithdrawStatuses
{
    public const CONFIRMED = 1;
    public const PENDING = 0;
    public const CANCELED = -1;

    public const WALLETS_TYPES = [
        self::CONFIRMED,
        self::PENDING,
        self::CANCELED,
    ];
}
