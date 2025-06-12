<?php

namespace ahmedWeb\LivePlatformManager\Models\Platform;

use ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    use SoftDeletes;

    protected $table = 'platforms';

    protected $guarded = [];

    public function live_accounts()
    {
        return $this->hasMany(LiveAccount::class);
    }
}
