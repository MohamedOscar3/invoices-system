<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $symbol
 * @property boolean $status
 */
class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.

     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'symbol' => $this->symbol,
            'status' => (bool)$this->status,
        ];
    }
}
