<?php

namespace App\Http\Livewire\Admin\Applications\GenerateReport;

use Livewire\Component;
use App\Exports\PermitReport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\{Result};
class AllReadyToExam extends Component
{
    // report type
    // 1 all ready to exam
    // 2 all applications

    public $report_modal=false;
    public $ready_to_download=false;
    public $selected_report ;
    public $examination;
    public function render()
    {
        return view('livewire.admin.applications.generate-report.all-ready-to-exam',[
            'result_count' => Result::query()
                                        ->where('examination_id', $this->examination)
                                        ->count(),
        ]);
    }

    public function updatedSelectedReport()
    {
        $this->ready_to_download=true;
    }

    public function startDownload()
    {
        switch ($this->selected_report) {
            case 1:
               return Excel::download(new PermitReport, 'readyToExam.xlsx');
                break;
            default:
                break;
        }
    }
}
