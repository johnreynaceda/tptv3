<?php

namespace App\Http\Livewire\Admin;

use App\Models\Permit;
use Livewire\Component;

class RegistrationDateReport extends Component
{
    protected $student_list;

    public function render()
    {
        $this->student_list = Permit::whereHas('user.personal_information')->paginate(100);
        return view('livewire.admin.registration-date-report', [
            'students' => $this->student_list
        ]);
    }
}
