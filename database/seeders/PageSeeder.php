<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('pages')->updateOrInsert(
            ['slug' => 'about-us'],
            [
                'title' => 'About Us',
                'meta_description' => 'Learn about DVLA (Damn Vulnerable Laravel Application) and the ArtisanBreach LLC training scenario behind it.',
                'page_content' => '<p>DVLA (Damn Vulnerable Laravel Application) is a deliberately '
                    .'vulnerable Laravel 12 application built for hands-on security training. Where tools '
                    .'like DVWA demonstrate generic, decade-old web vulnerabilities, DVLA models the way '
                    .'real modern Laravel applications actually fail: Eloquent mass assignment, PHP type '
                    .'juggling in custom auth, APP_KEY deserialization, IDOR, unrestricted file uploads, '
                    .'stored XSS, Redis job injection, and container escapes via docker.sock.</p>'
                    .'<p>It\'s built as a hands-on companion to a blog series that walks through the full '
                    .'kill chain, from the first recon step to host compromise, and is meant to be run '
                    .'locally or in an isolated VM only. Everywhere else on this site you\'ll see '
                    .'"ArtisanBreach LLC", that\'s the fictional company behind the lab\'s scenario, not '
                    .'a real business.</p>',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now(),
            ]
        );

        DB::table('pages')->updateOrInsert(
            ['slug' => 'contact'],
            [
                'title' => 'Contact Us',
                'meta_description' => 'Get in touch with the ArtisanBreach team, questions, account help, or something that looks off.',
                'page_content' => '<p>Have a question about ArtisanBreach, need a hand with your account, '
                    .'or found something that looks off? Send us a message below and our team will get '
                    .'back to you as soon as possible.</p>',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
