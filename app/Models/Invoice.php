<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'title',
        'description',
        'invoice_status_id',
        'payment_info',
        'total',
        'currency_id',
    ];

    /**
     * @return BelongsTo<InvoiceStatus,Invoice>
     */
    public function invoiceStatus(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class);
    }

    /**
     * @return BelongsTo<Currency,Invoice>
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }


    /**
     * @return HasMany<InvoiceTotal>
     */
    public function invoiceTotals(): HasMany
    {
        return $this->hasMany(InvoiceTotal::class);
    }
}



