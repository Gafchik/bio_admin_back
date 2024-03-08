<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Locations extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'locations';
}
