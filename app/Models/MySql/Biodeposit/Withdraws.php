<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Withdraws extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'withdraws';
}
