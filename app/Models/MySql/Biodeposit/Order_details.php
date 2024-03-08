<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Order_details extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'order_details';
}
