<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class RoleUsers extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'role_users';
}
