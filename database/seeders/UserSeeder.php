<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Administrator',
            'last_name' => 'User',
            'email' => 'admin@blueocean.com',
            'password' => bcrypt('password'),
        ]);
        $user = User::find(1);
        $user->assignRole('Administrator');

        User::factory()
            ->count(100)
            ->has(UserProfile::factory(), 'user_profile')
            ->create();
    }
}
