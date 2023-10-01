<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Currency */
class CurrencyCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array<string,JsonResource|string>
     */
    public function toArray(Request $request): array
    {
        return [
            'currencies' => $this->collection->transform(function ($currency) {
                return new CurrencyResource($currency);
            }),
            'pagination'=> new PaginationResource($this)
        ];
    }
}
