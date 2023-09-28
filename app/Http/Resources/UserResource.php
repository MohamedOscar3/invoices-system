<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $name
 * @property string $email
 * @property string $token
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string,string>
     */
    public function toArray(Request $request): array
    {
        return [
            "name"=>$this->name,
            "email"=>$this->email,
            "token"=>$this->token,
        ];
    }
}
