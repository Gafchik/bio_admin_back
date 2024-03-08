<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Provinces extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'provinces';
}
