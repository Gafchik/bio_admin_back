<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Roles extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'roles';
}
