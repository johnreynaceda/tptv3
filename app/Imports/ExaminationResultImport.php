<?php

namespace App\Imports;

use App\Models\Result;
use Maatwebsite\Excel\Concerns\ToModel;
class ExaminationResultImport implements ToModel
{
    public $examination_id;

    public function __construct($examination_id)
    {
        $this->examination_id = $examination_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // get examination id from url param
        return new Result([
            'examination_id' => $this->examination_id,
            'examinee_number'=>$row[0],
            'math_raw_score'=>$row[1],
            'math_standard_score'=>$row[2],
            'english_raw_score'=>$row[3],
            'english_standard_score'=>$row[4],
            'filipino_raw_score'=>$row[5],
            'filipino_standard_score'=>$row[6],
            'science_raw_score'=>$row[7],
            'science_standard_score'=>$row[8],
            'social_studies_raw_score'=>$row[9],
            'social_studies_standard_score'=>$row[10],
            'total_raw_score'=>$row[11],
            'total_standard_score'=>$row[12],
        ]);
    }
}
