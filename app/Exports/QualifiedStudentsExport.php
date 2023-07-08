<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QualifiedStudentsExport implements FromCollection, WithMapping, WithHeadings
{
    protected $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return $this->records;
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
}
