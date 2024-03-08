<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class DemoBalance extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'demo_balance';
}
