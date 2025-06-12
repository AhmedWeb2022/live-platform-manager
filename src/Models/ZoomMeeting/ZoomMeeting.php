<?php

namespace ahmedWeb\LivePlatformManager\Models\ZoomMeeting;

use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoomMeeting extends Model
{
    use SoftDeletes;

    protected $table = 'zoom_meetings';

    protected $guarded = [];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
    public function live_account()
    {
        return $this->belongsTo(LiveAccount::class);
    }
}
