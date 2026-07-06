<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('homes')->updateOrInsert(
            ['title' => 'Home'],
            [
                'meta_description' => 'DVLA: a deliberately vulnerable Laravel 12 + Livewire 3 application for AppSec training and OSWE exam preparation.',
                'page_content' => '',
            ]
        );
    }
}
