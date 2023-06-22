<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;


class QualifiedStudentsReport extends Component
{
    public $selected_campus;
    public $selected_program;
    public $qualified_students;
    public $campus_id;
    public $program_id;


    public function generateReport()
    {
        $this->qualified_students = Permit::whereHas('user.selected_courses', function ($query) {
                $query->where('priority_level', 1);

                if ($this->selected_campus) {
                    $query->whereHas('program', function ($query) {
                        $query->where('campus_id', $this->selected_campus);
                    });
                }

                if ($this->selected_program) {
                    $query->where('program_id', $this->selected_program);
                }
            })
            ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
            ->whereRaw('results.total_standard_score > 374')
            ->get();
    }

    public function render()
    {
        $campuses = Campus::get();

        $program_selects = Program::when($this->selected_campus, function ($query) {
                $query->where('campus_id', $this->selected_campus);
            })
            ->get();

        return view('livewire.admin.qualified-students-report', [
            'rankings' => $this->qualified_students,
            'campuses' => $campuses,
            'program_selects' => $program_selects
        ]);
    }
}
