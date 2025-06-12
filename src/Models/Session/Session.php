<?php

namespace ahmedWeb\LivePlatformManager\Models\Session;

use ahmedWeb\LivePlatformManager\Models\Live100msMeeting\Live100msMeeting;
use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use ahmedWeb\LivePlatformManager\Models\ZoomMeeting\ZoomMeeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    protected $table = 'platform_sessions';

    protected $guarded = [];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function live_account()
    {
        return $this->belongsTo(LiveAccount::class);
    }

    public function zoom_meeting()
    {
        return $this->hasOne(ZoomMeeting::class, 'session_id');
    }

    public function live_100ms()
    {
        return $this->hasOne(Live100msMeeting::class, 'session_id');
    }
}
