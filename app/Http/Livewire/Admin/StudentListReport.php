<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\Program;
use App\Models\Permit;
use WireUi\Traits\Actions;
use DB;

class StudentListReport extends Component
{
    use Actions;
    public $selected_campus;
    public $selected_program;
    public $students;
    public $updatedCount;
    public $permits_left;

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

    public function updatePermits()
    {

        $this->updatedCount = 0;
        // $this->permits_left = Permit::where('examinee_number_updated', null)->count();

       // DB::beginTransaction();
        Permit::where('examinee_number_updated', null)
        ->chunk(200, function ($permits) {
            foreach ($permits as $permit) {
                $paddedId = str_pad($permit->id, 4, '0', STR_PAD_LEFT);
                $permit->update(['examinee_number_updated' => $paddedId]);
                $this->updatedCount++;
            }
        });
        //DB::commit();
        $this->dialog()->success(
            $title = $this->updatedCount.' Permits updated'
        );
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
