<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ResultAllExport implements FromCollection, WithMapping, WithHeadings
{
    public $examination_id;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($examination_id)
    {
        $this->examination_id = $examination_id;
    }
    public function collection()
    {
        return Permit::query()
                        ->where('examination_id', $this->examination_id)
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
            $permit->user?->program_choices->where('is_priority',1)->first()->program->name,
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
            'First Priority Program',
            'Total Score'
        ] ;
    }
}
