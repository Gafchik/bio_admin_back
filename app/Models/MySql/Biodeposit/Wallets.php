<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Wallets extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'wallets';
}
