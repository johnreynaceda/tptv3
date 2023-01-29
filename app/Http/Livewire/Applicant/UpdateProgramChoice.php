<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\Campus;
use App\Models\ProgramChoice;
use WireUi\Traits\Actions;

class UpdateProgramChoice extends Component
{
    use Actions;
    public $priority;
    public $update_modal = false;
    public $choice_id;
    public function render()
    {
        return view('livewire.applicant.update-program-choice', [
            'campuses' => Campus::get(),
        ]);
    }

    public function save()
    {
        if ($this->choice_id == null) {
            $this->dialog()->error(
                $title = 'Error',
                $description = 'Please select a program'
            );
        } else {
            auth()
                ->user()
                ->program_choices()
                ->where('is_priority', $this->priority)
                ->first()
                ->update([
                    'program_id' => $this->choice_id,
                ]);
            $this->notification()->success(
                $title = 'Success',
                $description =
                    'Program choice updated successfully. Please refresh the page to see the changes.'
            );
            $this->update_modal = false;
        }
    }
}
