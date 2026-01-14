<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user_email' => $this->user ? $this->user->email : null,
            'description' => $this->description,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
