<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Orders extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'orders';
}
