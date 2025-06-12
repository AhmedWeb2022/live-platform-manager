<?php

namespace ahmedWeb\LivePlatformManager\Models\LiveAcount;

use ahmedWeb\LivePlatformManager\Models\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveAccount extends Model
{
    use SoftDeletes;

    protected $table = 'live_accounts';

    protected $guarded = [];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
