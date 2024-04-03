<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Images extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'images';
}
