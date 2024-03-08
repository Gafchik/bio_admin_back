<?php

namespace App\Http\Classes\Structure;

final class MonobankInvoiceStatuses
{
    public const CREATED = [
        'id' => 1,
        'name' => 'created' // - рахунок створено успішно, очікується оплата
    ];
    public const PROCESSING = [
        'id' => 2,
        'name' => 'processing' // - платіж обробляється
    ];
    public const HOLD = [
        'id' => 3,
        'name' => 'hold' // - сума заблокована
    ];
    public const SUCCESS = [
        'id' => 4,
        'name' => 'success' // - успішна оплата
    ];
    public const FAILURE = [
        'id' => 5,
        'name' => 'failure' // - неуспішна оплата
    ];
    public const REVERSED = [
        'id' => 6,
        'name' => 'reversed' // - оплата повернена після успіху
    ];
    public const EXPIRED = [
        'id' => 7,
        'name' => 'expired' // - час дії вичерпано
    ];
}
