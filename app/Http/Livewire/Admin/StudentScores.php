<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;
use Maatwebsite\Excel\Facades\Excel;

class StudentScores extends Component
{
    public $selected_campus;
    public $selected_program;
    public $qualified_students;
    public $campus_id;
    public $program_id;
    public $examination;
    public $student_name;

    public function generateReportByName()
    {
        $this->selected_campus = null;
        $this->selected_program = null;
        $this->qualified_students = Permit::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->student_name . '%')
                ->whereHas('selected_courses', function ($query) {
                    $query->where('priority_level', 1);
                });
        })
        ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
        ->get();
    }


    public function render()
    {
        return view('livewire.admin.student-scores', [
            'rankings' => $this->qualified_students,
        ]);
    }
}
