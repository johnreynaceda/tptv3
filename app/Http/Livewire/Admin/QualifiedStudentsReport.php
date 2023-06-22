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

    public function render()
    {
        $selected_campus_id = $this->selected_campus;
        $selected_program_id = $this->selected_program;

        $program_selects = Program::when($this->selected_campus, function ($query){
            $query->where('campus_id', $this->selected_campus);
        })
        ->when($selected_campus_id, function ($query) use ($selected_campus_id) {
            $query->where('campus_id', $selected_campus_id);
        })
        ->get();

        $rankings = Permit::whereHas('user.selected_courses', function ($query) use ($selected_campus_id, $selected_program_id) {
            $query->where('priority_level', 1);
            if ($selected_campus_id) {
                $query->whereHas('program', function ($query) use ($selected_campus_id) {
                    $query->where('campus_id', $selected_campus_id);
                });
            }
            if ($selected_program_id) {
                $query->where('program_id', $selected_program_id);
            }
        })
        ->join('results', 'permits.examinee_number', '=', 'results.examinee_number')
        ->whereRaw('results.total_standard_score > 374')
        ->paginate(100);

        $campuses = Campus::get();

        return view('livewire.admin.qualified-students-report', [
            'rankings' => $rankings,
            'campuses' => $campuses,
            'program_selects' => $program_selects
            ]);
    }
}
