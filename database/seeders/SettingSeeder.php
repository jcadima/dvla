<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'logo' => 'dvla_logo_varB.svg',
            'admin_logo' => 'dvla_logo_varB.svg',
            'mobile_logo' => 'dvla_logo_varB.svg',
            'google_ga'   => 'UA-0000000000000',
            'copyright' => 'All Rights Reserved by DVLA',
            'recipient' => 'email@artisanbreach.com',
        ]);
    }
}
