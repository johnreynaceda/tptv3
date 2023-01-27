<?php

namespace App\Http\Livewire\Admin\Examination;

use Livewire\Component;
use App\Models\Examination;
use WireUi\Traits\Actions;
class Update extends Component
{
    use Actions;
    public $shool_years=['2022-2023','2023-2024','2024-2025','2025-2026','2026-2027','2027-2028','2028-2029','2029-2030'];
    public $title,$school_year,$date_start,$date_end;
    protected $rules = [
        'title' => 'required|string|max:255',
        'school_year' => 'required',
        'date_start' => 'required',
        'date_end' => 'required',
    ];
    protected $listeners = ['edit'];
    public $examination;
    public function render()
    {
        return view('livewire.admin.examination.update');
    }

    public function edit($id)
    {
        $this->examination = Examination::where('id',$id)->first();
        $this->title = $this->examination->title;
        $this->school_year = $this->examination->school_year;
        $this->date_start = $this->examination->date_start;
        $this->date_end = $this->examination->date_end;
    }

    public function update()
    {
        $this->validate();
        $this->examination->update([
            'title' => $this->title,
            'school_year' => $this->school_year,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $this->reset();
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
        $this->notification([
            'title' => 'Success',
            'description' => 'Examination updated successfully',
            'icon' => 'success',
        ]);
    }
}
