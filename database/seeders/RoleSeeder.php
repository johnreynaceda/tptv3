<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Role,Type};
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Applicant',
        ]);
        Type::create([
            'name' => 'Freshmen',
        ]);
        Type::create([
            'name' => 'Transferee',
        ]);
    }
}
