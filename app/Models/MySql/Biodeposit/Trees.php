<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Trees extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'trees';
}
