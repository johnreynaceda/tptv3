<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;

class RankingResult extends Component
{
    public $selected_campus;
    public $selected_program;

    public function updatedSelectedCampus()
    {
        $this->selected_program = null;
    }

    public function render()
    {
        $selected_campus_id = $this->selected_campus;
        $selected_program_id = $this->selected_program;
        // $rankings = Permit::whereHas('user.selected_courses')
        // ->whereHas('result', function ($query) {
        //     $query->orderBy('total_standard_score', 'desc');
        // })->get();

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
        ->whereHas('result', function ($query) {
            $query->orderBy('total_standard_score', 'desc');
        })
        ->paginate(100);

        $program_selects = Program::when($this->selected_campus, function ($query){
            $query->where('campus_id', $this->selected_campus);
        })
        ->when($selected_campus_id, function ($query) use ($selected_campus_id) {
            $query->where('campus_id', $selected_campus_id);
        })
        ->get();

        $campuses = Campus::get();

        return view('livewire.admin.ranking-result', [
            'rankings' => $rankings,
            'campuses' => $campuses,
            'program_selects' => $program_selects

        ]);
    }
}
