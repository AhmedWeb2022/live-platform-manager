<?php

namespace ahmedWeb\LivePlatformManager\Database\Seeders\Platform;

use App\Models\Platform\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data[0] = [
            'name' => 'teacher.sa',
            'url' => 'https://teacher.success.sa/',
            'code' => 't1sm',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $data[1] = [
            'name' => 'sahel.sa',
            'url' => 'https://sahel.success.sa/',
            'code' => 's2so',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        foreach ($data as $platform) {
            \ahmedWeb\LivePlatformManager\Models\Platform\Platform::create($platform);
        }
    }
}
