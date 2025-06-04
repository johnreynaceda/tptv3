<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Examination;
use Illuminate\Support\Facades\DB;

class ExaminationWithResultPage extends Component
{
    use Actions;
    public $examinations = [];
    public $examinationId;

    
    public function mount()
    {
        $this->examinations = Examination::whereHas('results')->get();
    }
public function toggleShowResults($examinationId)
{
    $this->examinationId = $examinationId;
    $exam = Examination::findOrFail($examinationId);

    $this->dialog()->confirm([
        'title'       => 'Are you Sure?',
        'description' => 'Save the information?',
        'acceptLabel' => 'Yes, save it',
        'method'      => 'confirmToggleResults',
        'params'      => 'Saved',
    ]);

}

public function confirmToggleResults()
{
    DB::beginTransaction();
    $exam = Examination::findOrFail($this->examinationId);
    $exam->show_results = !$exam->show_results;
    $exam->save();

    $this->examinations = Examination::whereHas('results')->get();
    DB::commit();
    // $this->notification([
    //     'title' => 'Success',
    //     'description' => 'Results are now ' . ($exam->show_results ? 'available to the public' : 'hidden from the public'),
    //     'icon' => 'success',
    // ]);
}

    public function render()
    {
        return view('livewire.examination-with-result-page');
    }
}
