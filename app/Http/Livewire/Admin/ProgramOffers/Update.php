<?php

namespace App\Http\Livewire\Admin\ProgramOffers;

use Livewire\Component;
use App\Models\Program;
use WireUi\Traits\Actions;
class Update extends Component
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
    protected $listeners = ['edit'];
    public $program;
    public function render()
    {
        return view('livewire.admin.program-offers.update');
    }

    public function edit($id)
    {
        $this->program = Program::where('id',$id)->first();
        $this->name = $this->program->name;
        $this->abbreviation = $this->program->abbreviation;
        $this->campus_id = $this->program->campus_id;
    }

    public function update()
    {
        $this->validate();
        $this->program->update([
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'campus_id' => $this->campus_id,
        ]);

        $this->reset(['name','abbreviation','campus_id']);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('none');
        $this->notification([
            'title' => 'Success',
            'description' => 'Program updated successfully',
            'icon' => 'success',
        ]);
    }
}
