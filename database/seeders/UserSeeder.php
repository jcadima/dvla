<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminRole = Role::where('name', 'Administrator')->first();

        $admin = new User;
        $admin->name = 'Artisan Breach';
        $admin->email = 'admin@artisanbreach.com';
        $admin->password = 'artisanpass123';
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->role()->associate($adminRole);
        $admin->save();

        // Legacy contributor account, MD5 password retained from v1 CMS import.
        // md5("240610708") = "0e462097431906509019562988736854" (magic hash, ticket #2847)
        // Never demoted after the v1 import: still carries the Administrator role.
        $contributor = new User;
        $contributor->name = 'Sarah Okonkwo';
        $contributor->email = 'contributor@artisanbreach.com';
        $contributor->password = Hash::make(\Illuminate\Support\Str::random(32));
        $contributor->legacy_password = '0e462097431906509019562988736854';
        $contributor->created_at = Carbon::parse('2019-03-15');
        $contributor->updated_at = Carbon::parse('2019-03-15');
        $contributor->role()->associate($adminRole);
        $contributor->save();

        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            $user = new User;
            $user->name = $faker->name;
            $user->email = $faker->unique()->safeEmail;
            $user->password = 'password';
            $user->created_at = Carbon::now()->subDays(3);
            $user->updated_at = Carbon::now();
            // Generate random value for role ID between 1 and $totalRoles
            $roleId = $faker->numberBetween(1, 2);
            $user->role()->associate($roleId);

            $user->save();
        }
    }
}
