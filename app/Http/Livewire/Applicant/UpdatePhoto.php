<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\{PersonalInformation,User};
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
class UpdatePhoto extends Component
{
    use Actions, WithFileUploads;
    public $open_modal = false;
    public $personalInformation = null;
    public $photo;

    public function mount()
    {
        $this->personalInformation = PersonalInformation::where('user_id', auth()->user()->id)->first();
    }
    public function render()
    {
        return view('livewire.applicant.update-photo');
    }

    public function save()
    {
        $this->personalInformation->update([
            'photo' => $this->photo->store('photos', 'public'),
        ]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Photo updated successfully. Please refresh the page to see the changes.',
            'icon' => 'success',
        ]);
        $this->open_modal = false;
    }
}
