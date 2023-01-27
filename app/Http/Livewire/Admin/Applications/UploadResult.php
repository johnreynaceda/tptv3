<?php

namespace App\Http\Livewire\Admin\Applications;

use Livewire\Component;
use App\Models\{Application,Permit,Result,Examination};
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use App\Imports\ExaminationResultImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UploadResult extends Component
{
    use WithFileUploads, Actions;
    public $openModal = false;
    public $examination;
    public $file;
    protected $rules =[
        'file' => 'required|file|mimes:xls,xlsx',
    ];
    public function render()
    {
        return view('livewire.admin.applications.upload-result');
    }

    public function updatedFile()
    {
        $this->validate();
    }

    public function upload()
    {
        Excel::import(new ExaminationResultImport($this->examination), $this->file);
        $this->notification([
            'title' => 'Success',
            'description' => 'Successfully uploaded result',
            'icon' => 'success',
        ]);

        $this->file=null;
    }

}
