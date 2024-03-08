<?php

namespace App\Http\Classes\Structure;

final class WalletsType
{
    public const LIVE_PAY = null;
    public const BONUS = 'bonus';
    public const FUTURES = 'futures';

    public const WALLETS_TYPES = [
        self::LIVE_PAY,
        self::BONUS,
        self::FUTURES,
    ];
}
