<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Certificates extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'certificates';
}
