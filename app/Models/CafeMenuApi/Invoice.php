<?php

namespace App\Models\CafeMenuApi;

class Invoice extends ApiModel
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'invoice_number',
        'amount',
        'invoice_date',
        'due_date',
        'status',
    ];
}
