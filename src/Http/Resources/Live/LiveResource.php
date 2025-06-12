<?php

namespace ahmedWeb\LivePlatformManager\Http\Resources\Live;

use ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveResource extends JsonResource
{

    protected $type;
    protected $isDev;

    public function __construct($resource, $type, $isDev = false)
    {
        parent::__construct($resource);
        $this->type = $type;
        $this->isDev = $isDev;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type == PlatformTypeEnum::LIVE100MS->value) {
            return [
                'id' => $this->id,
                'room_id' => $this->room_id,
                'host_code' => $this->host_code,
                'guest_code' => $this->guest_code,
                'join_url' => $this->isDev ? $this->live_account->dev_link :  $this->live_account->join_url
            ];
        } elseif ($this->type == PlatformTypeEnum::ZOOM->value) {
            return [
                'id' => $this->id,
                'zoom_id' => $this->zoom_id,
                'password' => $this->password,
                'join_url' => $this->isDev ? $this->live_account->dev_link :  $this->live_account->join_url
            ];
        }
        return [];
    }
}
