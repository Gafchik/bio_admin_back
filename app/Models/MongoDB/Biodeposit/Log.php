<?php

namespace App\Models\MongoDB\Biodeposit;

use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'logs';
}
