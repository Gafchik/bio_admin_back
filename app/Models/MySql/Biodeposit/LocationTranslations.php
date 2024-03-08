<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class LocationTranslations extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'location_translations';
}
