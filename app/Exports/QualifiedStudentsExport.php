<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QualifiedStudentsExport implements FromCollection, WithMapping, WithHeadings
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
        return Permit::whereHas('user.selected_courses', function ($query) {
            $query->where('priority_level', 1);
        })
        ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
        ->whereRaw('results.total_standard_score > 374')
        ->get();
    }

    public function map($permit) : array {
        return [
            $permit->examinee_number,
            $permit->user?->name,
            $permit->result?->total_standard_score,
            $permit->user?->selected_courses->where('priority_level', 1)->first()?->program->campus->name,
            $permit->user?->selected_courses->where('priority_level', 1)->first()?->program->name,
        ] ;
    }

    public function headings() : array {
        return [
            'Examinee Number',
            'Name',
            'Total Standard Score',
            'Campus',
            'Selected Course',
        ] ;
    }
}
