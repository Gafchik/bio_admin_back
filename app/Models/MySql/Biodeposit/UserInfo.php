<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class UserInfo extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'user_info';
}
