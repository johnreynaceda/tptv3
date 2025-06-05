<?php

namespace App\Http\Livewire;

use App\Models\Result;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ExamineeResultDetails extends Component
{
    public $result;
    public $full_name;
    public $photo;
    public $user;
    public $examination;

    protected function scoreInterpretation($score)
    {
        if ($score >= 500) return 'Outstanding';
        if ($score >= 400) return 'Very Satisfactory';
        if ($score >= 300) return 'Satisfactory';
        if ($score >= 200) return 'Fair';
        return 'Needs Improvement';
    }

    public function mount(Result $result)
    {
        $this->result = $result->load(['examination']);
        $this->examination = $result->examination;
        
        // Get user data
        $this->user = User::whereHas('permit', function($query) use ($result) {
            $query->where('examinee_number', $result->examinee_number);
        })->with('personal_information')->first();

        // Set full name
        $this->full_name = $result->full_name;
        
        // Set photo with fallback
        $this->photo = $this->user && $this->user->personalInformation && $this->user->personalInformation->photo
            ? asset('storage/' . $this->user->personalInformation->photo)
            : asset('images/placeholder.png');
    }

    public function render()
    {
        return view('livewire.examinee-result-details');
    }
}
