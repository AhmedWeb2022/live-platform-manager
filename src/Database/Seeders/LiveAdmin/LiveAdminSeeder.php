<?php

namespace ahmedWeb\LivePlatformManager\Database\Seeders\LiveAdmin;

use App\Models\LiveAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiveAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data['name'] = 'admin';
        $data['email'] = 'admin@example.com';
        $data['password'] = '123123123';
        $data['created_at'] = now();
        $data['updated_at'] = now();

        \ahmedWeb\LivePlatformManager\Models\LiveAdmin\LiveAdmin::create($data);
    }
}
