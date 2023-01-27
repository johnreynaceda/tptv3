<?php

namespace App\Exports;

use App\Models\Permit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class PermitReport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Permit::with(['user'=>['personal_information']])->get();
    }

    public function map($permit) : array {
        return [
            $permit->examinee_number,
            $permit->user->personal_information->first_name,
            $permit->user->personal_information->middle_name,
            $permit->user->personal_information->last_name,
            $permit->user->personal_information->extension,
            $permit->user->personal_information->sex,
        ] ;
    }
    public function headings() : array {
        return [
            'Examinee Number',
            'First Name',
            'Middle Name',
            'Last Name',
            'Extension',
            'Sex'
        ] ;
    }
}
