<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $social = [
            [
                'link' => 'https://youtube.com',
                'facode' => '<i class="fa-brands fa-youtube"></i>',
            ],
            [
                'link' => 'https://www.instagram.com/',
                'facode' => '<i class="fa-brands fa-instagram"></i>',
            ],
            [
                'link' => 'https://www.facebook.com',
                'facode' => '<i class="fa-brands fa-facebook-f"></i>',
            ],
        ];

        DB::table('socials')->insert($social);
    }
}
