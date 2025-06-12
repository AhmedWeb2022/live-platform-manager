<?php

namespace ahmedWeb\LivePlatformManager\Database\Seeders\LiveAccount;

use App\Enums\PlatformTypeEnum;
use App\Models\LiveAcount\LiveAccount;
use App\Models\Platform\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiveAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = \ahmedWeb\LivePlatformManager\Models\Platform\Platform::all();

        foreach ($platforms as $platform) {
            $data[0] = [
                'platform_id' => $platform->id,
                'name' => \ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum::ZOOM->lable() . ' ' . $platform->id,
                'client_id' => 'TvDVxEtJT66oxTS46v7BFA',
                'client_secret' => 'P8NSwR8CLsjC5lUaGmUCVTEK3SD2G7oG',
                'account_id' => 'e422FKYwQNqMHnlMagD1bQ',
                'sdk_key' => 'fuaa9BP3SPibOr3eV1IHWg',
                'sdk_secret' => 'AHWXyebd7VsQYn7hW5nTm9ehFgeDBQke',
                'integeration_type' => \ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum::ZOOM->value,
                'join_url' => 'https://zoom.success.sa/?user=%d&sessionId=%d&userId=%s&type=%d',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $data[1] = [
                'platform_id' => $platform->id,
                'name' => \ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum::LIVE100MS->lable() . ' ' . $platform->id,
                'client_id' => '66582e9ed36830c2c67d6ec7',
                'client_secret' => 'Qp3VXvSkC3NfKaHUhlkGEk1ciiUcKAqqERe4wG9sj7V-rCQvdV3GXr1HiUKXW9kEVPEI0OtahWJNdenmErq5-Bqx2NI4mpJ_FLnR7vRmsi8pl58xbN1cgVgz9ul6Xk7gdnXOaMCrhNMpSmz7jnWOykLyGZFyWECNe6kaUZmkhNI=',
                'integeration_type' => \ahmedWeb\LivePlatformManager\Enums\PlatformTypeEnum::LIVE100MS->value,
                'join_url' => 'https://live.success.sa/?roomId=%s&userName=%s&teacherId=%d&sessionId=%d&type=%s&role=%s',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            foreach ($data as $account) {
                \ahmedWeb\LivePlatformManager\Models\LiveAcount\LiveAccount::create($account);
            }
        }
    }
}
