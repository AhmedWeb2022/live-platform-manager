<?php

namespace ahmedWeb\LivePlatformManager\Http\Resources\Session;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'live_account_id' => $this->live_account_id,
            'session_id' => $this->platform_session_id,
        ];
    }
}
