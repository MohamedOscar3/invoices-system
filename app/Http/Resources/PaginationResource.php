<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method int  total()
 * @method int perPage()
 * @method int  currentPage()
 * @method int lastPage()
 * @method int firstItem()
 * @method int lastItem()
 */
class PaginationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string,int>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
        ];
    }
}
