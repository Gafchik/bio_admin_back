<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Transactions extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'transactions';
}
