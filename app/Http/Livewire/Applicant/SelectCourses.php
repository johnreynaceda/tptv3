<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\Program;
use App\Models\SelectedCourse;
use WireUi\Traits\Actions;
use DB;

class SelectCourses extends Component
{
    use Actions;
    public $first_priority;
    public $second_priority;
    public $third_priority;

    public function render()
    {
        return view('livewire.applicant.select-courses',[
            'courses' => Program::get(),
        ]);
    }

    public function updatedFirstPriority($value)
    {
        if ($value) {
            $this->second_priority = ($this->second_priority === $value) ? null : $this->second_priority;
            $this->third_priority = ($this->third_priority === $value) ? null : $this->third_priority;
        }
    }

    public function updatedSecondPriority($value)
    {
        if ($value) {
            $this->first_priority = ($this->first_priority === $value) ? null : $this->first_priority;
            $this->third_priority = ($this->third_priority === $value) ? null : $this->third_priority;
        }
    }

    public function updatedThirdPriority($value)
    {
        if ($value) {
            $this->first_priority = ($this->first_priority === $value) ? null : $this->first_priority;
            $this->second_priority = ($this->second_priority === $value) ? null : $this->second_priority;
        }
    }

    public function save()
    {
        $has_selected_courses = SelectedCourse::where('user_id',  auth()->user()->id)->exists();
        $this->validate([
            'first_priority' => 'required',
            'second_priority' => 'required',
            'third_priority' => 'required',
        ],
        [
            'first_priority.required' => 'Please select a course.',
            'second_priority.required' => 'Please select a course',
            'third_priority.required' => 'Please select a course',
        ]);
        DB::beginTransaction();
        if($has_selected_courses)
        {
            $this->dialog()->error(
                $title = 'Operation Failed!',
                $description = 'You already selected your preferred courses.'
            );
        }else{
            $priority_one = SelectedCourse::create([
                'user_id' => auth()->user()->id,
                'program_id' => $this->first_priority,
                'priority_level' => 1,
            ]);
            $priority_two = SelectedCourse::create([
                'user_id' => auth()->user()->id,
                'program_id' => $this->second_priority,
                'priority_level' => 2,
            ]);
            $priority_three = SelectedCourse::create([
                'user_id' => auth()->user()->id,
                'program_id' => $this->third_priority,
                'priority_level' => 3,
            ]);
            DB::commit();
            $this->dialog()->success(
                $title = 'Success',
                $description = 'Your selected courses are saved.'
            );

            return redirect()->route('print.result');
    }
    }
}
