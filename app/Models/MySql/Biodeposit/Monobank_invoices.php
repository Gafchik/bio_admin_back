<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Monobank_invoices extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'monobank_invoices';
}
