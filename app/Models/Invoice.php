<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $appends = ["last_trans_ref"];



    protected $fillable = [
        'title',
        'description',
        'invoice_status_id',
        'total',
        'currency_id',
    ];

    protected $casts = [
        'payment_info' => 'collection',
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

    public function invoiceTransactions(): HasMany
    {
        return $this->hasMany(InvoiceTransaction::class);
    }


    protected function lastTransRef(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->invoiceTransactions()->where("tran_ref","!=","invalid")->latest()->first()->tran_ref,
        );
    }
}



