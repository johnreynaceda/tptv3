<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'first_name' => 'SKSU',
            'middle_name' => '',
            'last_name' => 'TPT',
            'email' => 'sksu@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
