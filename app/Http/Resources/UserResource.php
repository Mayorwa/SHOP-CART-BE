<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    public function toArray($request): array | Arrayable | \JsonSerializable
    {

        return [
            'name' => $this->first_name. ' '. $this->last_name,
            'email' => $this->type === 'customer' ? '' : $this->email,
            'phone_number' => $this->phone,
            'avatar' => $this->avatar,
            'type' => $this->type,
            'slug' => $this->slug,
            'token' => $this->token,
            'created_at' => Carbon::parse($this->created_at)->calendar(),
        ];
    }
}
