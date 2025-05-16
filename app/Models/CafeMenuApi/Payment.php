<?php

namespace App\Models\CafeMenuApi;

class Payment extends ApiModel
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
    ];
}
