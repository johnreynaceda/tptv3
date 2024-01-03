<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class AccountSeeder extends Seeder
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
            'email' => 'sksutpt@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
