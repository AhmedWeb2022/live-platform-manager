<?php

namespace ahmedWeb\LivePlatformManager\Http\Resources\LiveAccount;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveAccountResource extends JsonResource
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
            'platform_id' => $this->platform_id,
            'platform_type' => $this->integeration_type,
            'name' => $this->name,
            'type' => $this->integeration_type,
        ];
    }
}
