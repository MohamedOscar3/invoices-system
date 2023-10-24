<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTransaction extends Model
{
    protected $fillable = [
        'invoice_id',
        'invoice_status_id',
        'request_type',
        'tran_ref',
        'tran_type',
        'payment_info',
    ];

    protected $casts = [
        'payment_info' => 'json',
    ];
}
