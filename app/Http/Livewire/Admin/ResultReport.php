<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Permit;
use App\Models\Campus;
use App\Models\Program;

class ResultReport extends Component
{
    public $remarks;
    public $selected_campus;
    public $selected_program;

    public function mount()
    {
        $this->remarks = null;
    }

    public function updatedSelectedCampus()
    {
        $this->selected_program = null;
    }
    public function render()
    {

        $selected_campus_id = $this->selected_campus;
        $programs = Program::when($selected_campus_id, function ($query, $selected_campus_id) {
            return $query->whereHas('selected_courses', function ($query) use ($selected_campus_id) {
                $query->where('campus_id', $selected_campus_id);
            })->when($this->selected_program, function ($query) {
                $query->where('id', $this->selected_program);
            });
        })->get();

        $program_selects = Program::when($this->selected_campus, function ($query){
            $query->where('campus_id', $this->selected_campus);
        })->get();

        $campuses = Campus::get();

        return view('livewire.admin.result-report', [
            'programs' => $programs,
            'campuses' => $campuses,
            'program_selects' => $program_selects

        ]);
    }
}
