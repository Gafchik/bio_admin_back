<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Contacts extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'contacts';
}
