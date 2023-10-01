<?php

namespace App\Http\Resources;


use App\Models\Currency;
use App\Models\InvoiceTotal;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $title
 * @property int $description
 * @property Currency $currency
 * @property float $total
 * @property Collection $invoiceTotals
 */
class InvoiceResource extends JsonResource
{

    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'currency' => $this->currency->title,
            'cost' => $this->total,
            'totals' => $this->invoiceTotals->map(function ($total) {
                return [
                    'title' => $total->title,
                    'cost' => $total->price,
                    'type' => $total->type,
                ];
            }),
        ];
    }
}

