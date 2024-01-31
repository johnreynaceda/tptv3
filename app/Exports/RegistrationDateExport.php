<?php

namespace App\Exports;

use App\Models\Permit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationDateExport implements FromView
{
    public $examination_id;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($examination_id)
    {
        $this->examination_id = $examination_id;
    }

    public function view(): View
    {
        return view('exports.invoices', [
            'students' => Permit::whereHas('user.personal_information')->get()
        ]);
    }
}
