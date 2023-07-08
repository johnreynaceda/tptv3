<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QualifiedStudentsExport implements FromQuery, WithMapping, WithHeadings
{
    public $examination_id;

    public function __construct($examination_id)
    {
        $this->examination_id = $examination_id;
    }

    public function query()
    {
        return Permit::query()
            ->whereHas('user.selected_courses', function ($query) {
                $query->where('priority_level', 1);
            })
            ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
            ->whereRaw('results.total_standard_score > 374');
    }

    public function map($permit): array
    {
        return [
            $permit->examinee_number,
            optional($permit->user)->name,
            optional($permit->result)->total_standard_score,
            optional($permit->user->selected_courses->where('priority_level', 1)->first())->program->campus->name,
            optional($permit->user->selected_courses->where('priority_level', 1)->first())->program->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Examinee Number',
            'Name',
            'Total Standard Score',
            'Campus',
            'Selected Course',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }
}
