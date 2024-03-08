<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Payments extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'payments';
}
