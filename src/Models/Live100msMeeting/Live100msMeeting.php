<?php

namespace ahmedWeb\LivePlatformManager\Models\Live100msMeeting;

use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use ahmedWeb\LivePlatformManager\Models\Platform\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Live100msMeeting extends Model
{
    use SoftDeletes;

    protected $table = 'live100ms_meetings';

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
