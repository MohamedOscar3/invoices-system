<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoiceCollection extends ResourceCollection
{
    /**
     * @param $request
     * @return array<string,JsonResource|string>
     */
    public function toArray($request): array
    {
        return [
            'invoices' => $this->collection->transform(function ($invoice) {
               return new InvoiceResource($invoice);
            }),
            'pagination' => new PaginationResource($this)
        ];
    }
}
