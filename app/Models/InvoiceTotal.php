<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class InvoiceTotal extends Model
{
    protected $fillable = [
        'title',
        'type',
        'price',
        'invoice_id',
    ];

    /**
     * @return BelongsTo<Invoice,InvoiceTotal>
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
