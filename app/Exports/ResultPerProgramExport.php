<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ResultPerProgramExport implements FromCollection, WithMapping, WithHeadings
{
    public $examination_id, $program_id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($examination_id, $program_id)
    {
        $this->examination_id = $examination_id;
        $this->program_id = $program_id;
    }
    public function collection()
    {
        return Permit::query()
                        ->where('examination_id', $this->examination_id)
                        ->whereHas('user.program_choices', function($query) {
                            $query->where('program_id', $this->program_id)->where('is_priority',1);
                        })
                        ->with([
                            'user'=>[
                                'personal_information',
                                'program_choices'=>[
                                    'program'
                                ]
                            ],
                            'result',
                        ])->get();
    }

    public function map($permit) : array {
        return [
            $permit->examinee_number,
            $permit->user?->personal_information->first_name,
            $permit->user?->personal_information->middle_name,
            $permit->user?->personal_information->last_name,
            $permit->user?->personal_information->extension,
            $permit->user?->personal_information->sex,
            $permit->result?->total_standard_score,
        ] ;
    }

    public function headings() : array {
        return [
            'Examinee Number',
            'First Name',
            'Middle Name',
            'Last Name',
            'Extension',
            'Sex',
            'Total Score'
        ] ;
    }
}
