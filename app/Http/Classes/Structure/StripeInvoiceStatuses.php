<?php

namespace App\Http\Classes\Structure;

final class StripeInvoiceStatuses
{
    public const CREATED = [
        'id' => 1,
        'name' => 'created', // - рахунок створено успішно, очікується оплата
        'stripe_name' => 'unpaid' // - не оплачено
    ];
    public const PROCESSING = [
        'id' => 2,
        'name' => 'processing' // - платіж обробляється
    ];
    public const EXPIRED = [
        'id' => 3,
        'name' => 'expired', // - час дії вичерпано
        'stripe_name' => 'checkout.session.expired'
    ];
    public const SUCCESS = [
        'id' => 4,
        'name' => 'success', // - успішна оплата
        'stripe_name' => 'checkout.session.completed'
    ];
}
