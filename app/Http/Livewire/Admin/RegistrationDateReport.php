<?php

namespace App\Http\Livewire\Admin;

use App\Models\Permit;
use Livewire\Component;
use App\Models\Examination;
use App\Exports\RegistrationDateExport;
use Maatwebsite\Excel\Facades\Excel;

class RegistrationDateReport extends Component
{
    protected $student_list;
    public $examination;
    public $search;
    public $from;
    public $to;

    public function export()
    {
        return Excel::download(new RegistrationDateExport($this->examination), 'registration-dates.xlsx');
    }

    public function mount()
    {
        $this->examination = Examination::where('is_active', 1)->first();
    }

    public function render()
    {
        $this->student_list = Permit::whereHas('user.personal_information', function ($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        })->paginate(100);
        return view('livewire.admin.registration-date-report', [
            'students' => $this->student_list
        ]);
    }
}
