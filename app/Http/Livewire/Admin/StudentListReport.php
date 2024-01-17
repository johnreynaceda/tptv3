<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;

class StudentListReport extends Component
{
    public $selected_campus;
    public $selected_program;
    public $students;

    public function updatedSelectedCampus()
    {
        $this->selected_program = null;
        $this->students = null;
    }

    public function generateReport()
    {
        $this->students = Permit::whereHas('user.program_choices', function ($query) {
                $query->where('is_priority', 1);

                if ($this->selected_campus) {
                    $query->whereHas('program', function ($query) {
                        $query->where('campus_id', $this->selected_campus);
                    });
                }

                if ($this->selected_program) {
                    $query->where('program_id', $this->selected_program);
                }
            })
            // ->when($this->student_name, function ($query) {
            //     $query->whereHas('user', function ($query) {
            //         $query->where('name', 'like', '%' . $this->student_name . '%');
            //     });
            // })
            ->get();
    }

    public function render()
    {
        $campuses = Campus::get();

        $program_selects = Program::when($this->selected_campus, function ($query) {
                $query->where('campus_id', $this->selected_campus);
            })
            ->get();

        return view('livewire.admin.student-list-report', [
            'campus_name' => Campus::where('id', $this->selected_campus)->first()?->name,
            'program_name' => Program::where('id', $this->selected_program)->first()?->name,
            'campuses' => $campuses,
            'program_selects' => $program_selects
        ]);
    }
}
