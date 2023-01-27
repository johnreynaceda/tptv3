<?php

namespace App\Http\Livewire\Admin\Applications\GenerateReport;

use Livewire\Component;
use App\Exports\{ResultAllExport,ResultPerProgramExport};
use Maatwebsite\Excel\Facades\Excel;
use App\Models\{Program,Campus};
use WireUi\Traits\Actions;

class DownloadResult extends Component
{
    use Actions;
    public $examination;
    public $download_modal = false;
    public $current_downloading='';
    public $is_downloading = false;

    public $selected_program,$file_name;
    public $programs=[];
    public function mount()
    {
        $this->programs = Program::all();
    }
    public function render()
    {
        return view('livewire.admin.applications.generate-report.download-result');
    }

    public function downloadAll()
    {
        return  Excel::download(new ResultAllExport($this->examination), 'allresult.xlsx');
    }

    public function downloadPerProgram()
    {
        $this->validate([
            'selected_program' => 'required',
            'file_name' => 'required',
        ]);
        $this->file_name = str_replace(' ', '', $this->file_name);
        return Excel::download(new ResultPerProgramExport($this->examination,$this->selected_program), 'result_'.$this->file_name.'.xlsx');
    }

    public function downloadPerCampus()
    {
        $this->notification([
            'title' => 'Not Implemented',
            'description' => 'This feature is not yet implemented',
            'icon' => 'error',
        ]);
    }

    
}
