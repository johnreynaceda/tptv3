<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Examination;
use WireUi\Traits\Actions;

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
        'title'       => $exam->show_results ? 'Hide Results?' : 'Publish Results?',
        'description' => $exam->show_results 
            ? 'Are you sure you want to hide these results from the public?' 
            : 'Are you sure you want to make these results public?',
        'icon'        => $exam->show_results ? 'question' : 'exclamation',
        'accept'      => [
            'label'  => 'Yes, ' . ($exam->show_results ? 'hide' : 'publish') . ' results',
            'method' => 'confirmToggleResults',
        ],
        'reject' => [
            'label'  => 'Cancel',
        ],
    ]);
}

public function confirmToggleResults()
{
    $exam = Examination::findOrFail($this->examinationId);
    $exam->show_results = !$exam->show_results;
    $exam->save();

    $this->examinations = Examination::whereHas('results')->get();

    $this->notification([
        'title' => 'Success',
        'description' => 'Results are now ' . ($exam->show_results ? 'available to the public' : 'hidden from the public'),
        'icon' => 'success',
    ]);
}

    public function render()
    {
        return view('livewire.examination-with-result-page');
    }
}
