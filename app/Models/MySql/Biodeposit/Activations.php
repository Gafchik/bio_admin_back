<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Activations extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'activations';
}
