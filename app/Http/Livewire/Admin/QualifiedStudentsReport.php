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
        $batchSize = 1000;
        $totalRecords = 7500;

        for ($start = 0; $start < $totalRecords; $start += $batchSize) {
            $end = $start + $batchSize;

            // Retrieve records for the current range
            $records = Permit::whereHas('user.selected_courses', function ($query) {
                $query->where('priority_level', 1);
            })
            ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
            ->whereRaw('results.total_standard_score > 374')
            ->skip($start)
            ->take($batchSize)
            ->get();

            // Export the records using the QualifiedStudentsExport class
            $filename = "qualified_students_{$start}_{$end}.xlsx";
            return Excel::download(new QualifiedStudentsExport($records), $filename);
            // Excel::store(new QualifiedStudentsExport($records), $filename);
        }


        // $records = Permit::whereHas('user.selected_courses', function ($query) {
        //     $query->where('priority_level', 1);
        // })
        // ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
        // ->whereRaw('results.total_standard_score > 374')
        // ->take(1000)
        // ->get();
        // return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_1_1000.xlsx');
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
