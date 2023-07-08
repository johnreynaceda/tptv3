<?php

namespace App\Http\Livewire\Admin;

use App\Exports\QualifiedStudentsExport;
use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;
use Maatwebsite\Excel\Facades\Excel;


class QualifiedStudentsReport extends Component
{
    public $selected_campus;
    public $selected_program;
    public $qualified_students;
    public $campus_id;
    public $program_id;
    public $examination;

    public function updatedSelectedCampus()
    {
        $this->selected_program = null;
        $this->qualified_students = null;
    }


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

    public function downloadQualifiedStudents()
    {
        return  Excel::download(new QualifiedStudentsExport($this->examination), 'qualifiedStudents.xlsx');
    }

    public function mount()
    {
        // $this-
    }

    public function render()
    {
        $campuses = Campus::get();

        $program_selects = Program::when($this->selected_campus, function ($query) {
                $query->where('campus_id', $this->selected_campus);
            })
            ->get();

        return view('livewire.admin.qualified-students-report', [
            'campus_name' => Campus::where('id', $this->selected_campus)->first()?->name,
            'program_name' => Program::where('id', $this->selected_program)->first()?->name,
            'rankings' => $this->qualified_students,
            'campuses' => $campuses,
            'program_selects' => $program_selects
        ]);
    }
}
