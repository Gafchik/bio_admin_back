<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class DicCurrencies extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'dic_currencies';
}
