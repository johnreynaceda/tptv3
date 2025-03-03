<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            $this->call(CampusSeeder::class);
            $this->call(RoleSeeder::class);
            $this->call(AccountSeeder::class);
            $this->call(UserSeeder::class);
    }
}
