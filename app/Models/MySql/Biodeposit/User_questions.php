<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class User_questions extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'user_questions';
}
