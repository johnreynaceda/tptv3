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
    function exportRange1To1000()
    {
        $records = $this->retrieveRecordsInRange(1, 1000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_1_1000.xlsx');
    }

    function exportRange1001To2000()
    {
        $records = $this->retrieveRecordsInRange(1001, 2000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_1001_2000.xlsx');
    }

    function exportRange2001To3000()
    {
        $records = $this->retrieveRecordsInRange(2001, 3000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_2001_3000.xlsx');
    }

    function exportRange3001To4000()
    {
        $records = $this->retrieveRecordsInRange(3001, 4000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_3001_4000.xlsx');
    }

    function exportRange4001To5000()
    {
        $records = $this->retrieveRecordsInRange(4001, 5000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_4001_5000.xlsx');
    }

    function exportRange5001To6000()
    {
        $records = $this->retrieveRecordsInRange(5001, 6000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_5001_6000.xlsx');
    }

    function exportRange6001To7000()
    {
        $records = $this->retrieveRecordsInRange(6001, 7000);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_6001_7000.xlsx');
    }

    function exportRange7001To7500()
    {
        $records = $this->retrieveRecordsInRange(7001, 7500);
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_7001_7500.xlsx');
    }

    function retrieveRecordsInRange($start, $end)
    {
            return Permit::whereHas('user.selected_courses', function ($query) {
                $query->where('priority_level', 1);
            })
            ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
            ->whereRaw('results.total_standard_score > 374')
            ->skip($start - 1)  // Subtract 1 to account for 1-based index
            ->take($end - $start + 1)
            ->get();
    }

    function exportRecords($records, $filename)
    {
        return Excel::download(new QualifiedStudentsExport($records), $filename);
        // Excel::download(new QualifiedStudentsExport($records), $filename);
    }

    public function downloadQualifiedStudents()
    {
        $records = Permit::whereHas('user.selected_courses', function ($query) {
            $query->where('priority_level', 1);
        })
        ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
        ->whereRaw('results.total_standard_score > 374')
        ->take(1000)
        ->get();
        return Excel::download(new QualifiedStudentsExport($records), 'qualified_students_1_1000.xlsx');
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
