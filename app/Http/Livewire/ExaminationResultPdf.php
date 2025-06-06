<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ExaminationResultPdf extends Component
{

    public $result;
    public $full_name;
    public $photo;
    public $user;
    public $examination;

    protected function stanineInterpretation($stanine)
{
    if ($stanine == 9) return 'Outstanding';
    if ($stanine == 8) return 'Above Average';
    if ($stanine == 7) return 'Above Average';
    if ($stanine == 6) return 'High Average';
    if ($stanine == 5) return 'Middle Average';
    if ($stanine == 4) return 'Low Average';
    if ($stanine == 3) return 'Below Average';
    if ($stanine == 2) return 'Below Average';
    if ($stanine == 1) return 'Low';
    return '';
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
        $this->photo = $this->user && $this->user->personal_information && $this->user->personal_information->photo
            ? Storage::url($this->user->personal_information->photo)
            : asset('images/placeholder.png');
    }
    public function render()
    {
        return view('livewire.examination-result-pdf');
    }
}
