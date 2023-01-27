<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campus;
class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campus = Campus::create([
                'name'=>"ACCESS Campus"
            ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Elementary Education"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Secondary Education major in: Filipino"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Secondary Education major in: Science"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Secondary Education major in: Mathematics"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Secondary Education major in: Social Studies"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor in Physical Education"
        ]);
        $campus->programs()->create([
            'name'=>"Bachelor of Science in Agriculture"
        ]);
            $campus = Campus::create([
                'name'=>"Isulan Campus"
            ]);

            $campus->programs()->create([
                'name'=>"Bachelor of Science in Electronics and Communication Engineering"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Computer Engineering"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Computer Science"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Information Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Information System"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Drafting Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Food Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Automotive Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Electrical Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Electronics Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Industrial Technology major in: Civil Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical-Vocational Teacher Education major in: Drafting Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical-Vocational Teacher Education major in: Food Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical Teacher Education major in: Automotive Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical-Vocational Teacher Education major in: Electrical Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical-Vocational Teacher Education major in: Electronics Technology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor in Technical-Vocational Teacher Education major in: Civil Technology"
            ]);

            $campus = Campus::create([
                'name'=>"Tacurong Campus"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Biology"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Arts in Economics"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Arts in Political Science"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Hospitality Management"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Entrepreneurship"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Accountancy"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Accounting Information System"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Tourism Management"
            ]);
            $campus->programs()->create([
                'name'=>"Bachelor of Science in Management Accounting"
            ]);
    
        $campus = Campus::create([
            "name" => "Kalamansig Campus"
        ]);

        $campus->programs()->create([
            "name" => "Bachelor of Science in Fisheries"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Secondary Education major in: English"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Secondary Education major in: Filipino"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Secondary Education major in: Science"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Elementary Education"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Information Technology"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Biology"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Criminology"
        ]);

        
        $campus = Campus::create([
            "name" => "Bagumbayan Campus"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Agribusiness"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Technology and Livelihood Education major in Agri-fishery"
        ]);


        $campus = Campus::create([
            "name" => "Palimbang Campus"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor in Elementary Education"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Agribusiness"
        ]);


        $campus = Campus::create([
            "name" => "Lutayan Campus"
        ]);
        $campus->programs()->create([
            "name" => " Bachelor in Elementary Education"
        ]);
        $campus->programs()->create([
            "name" => "Bachelor of Science in Agriculture"
        ]);
    }
}
