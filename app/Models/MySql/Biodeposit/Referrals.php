<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Referrals extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'referrals';
}
