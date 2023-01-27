<?php

namespace App\Http\Livewire\Admin\ProgramOffers;

use Livewire\Component;
use App\Models\Program;
use WireUi\Traits\Actions;
class Create extends Component
{
    use Actions;
    public $name,$abbreviation,$campus_id='';
    public $campuses=[];
    protected $validationAttributes=[
        'campus_id'=>'campus',
    ];
    protected $rules = [
        'name' => 'required|string|max:255',
        'abbreviation' => 'required|string|max:255',
        'campus_id' => 'required|integer',
    ];
    public function render()
    {
        return view('livewire.admin.program-offers.create');
    }

    public function store()
    {
        $this->validate();
        Program::create([
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'campus_id' => $this->campus_id,
        ]);
        $this->reset(['name','abbreviation','campus_id']);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
        $this->notification([
            'title' => 'Success',
            'description' => 'Program created successfully',
            'icon' => 'success',
        ]);
    }
}
