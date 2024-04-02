<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class News extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'news';
}
