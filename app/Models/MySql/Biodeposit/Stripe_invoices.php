<?php

namespace App\Models\MySql\Biodeposit;

use App\Models\BaseModel;

class Stripe_invoices extends BaseModel
{
    protected $connection = 'biodeposit';
    protected $table = 'stripe_invoices';
}
