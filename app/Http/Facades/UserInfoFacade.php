<?php

namespace App\Http\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static array getUserInfo(string $fieldName, string $fieldValue);
 * @method static ?array findDemoBalance(string $fieldBySearch, $value, string $uuid = null);
 * @see UserInfoInterface
 */
class UserInfoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user_info_facade';
    }
}
