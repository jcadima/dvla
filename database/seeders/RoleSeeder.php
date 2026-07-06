<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            [
                'name' => 'Administrator',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'Editor',
                'created_at' => Carbon::now()->subDays(1),
            ],

        ];

        DB::table('roles')->insert($roles);
    }
}
