<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/sql/postcodes.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
        $this->command->info('Your data has been seeded from SQL file!');
    }
}
