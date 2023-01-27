<?php

namespace App\Http\Livewire\Admin\ProgramOffers;

use Livewire\Component;
use App\Models\Program;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
class Table extends Component
{
    use WithPagination, Actions;
    public $search='';
    protected $listeners = ['refresh' => '$refresh'];
    public $program_id;
    public function render()
    {
        return view('livewire.admin.program-offers.table',[
            'programs'=>Program::where('name','like','%'.$this->search.'%')->with(['campus'])->paginate(10)
        ]);
    }

    public function edit($id)
    {
        $this->emit('edit',$id);
        $this->dispatchBrowserEvent('edit');
    }

    public function delete($id)
    {
        $this->program_id=$id;
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'You are about to delete this program',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Delete it',
                'method' => 'confirmDelete',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmDelete()
    {
        Program::find($this->program_id)->delete();
        $this->notification([
            'title' => 'Success',
            'description' => 'Program deleted successfully',
            'icon' => 'success',
        ]);
    }

    public function add($id)
    {
        $program = Program::where('id',$id)->first();
        $program->update([
            'is_offered' => 1
        ]);

        $this->notification([
            'title' => 'Success',
            'description' => 'Program added successfully',
            'icon' => 'success',
        ]);
    }

    public function remove($id)
    {
        $program = Program::where('id',$id)->first();
        $program->update([
            'is_offered' => 0
        ]);

        $this->notification([
            'title' => 'Success',
            'description' => 'Program removed successfully',
            'icon' => 'success',
        ]);
    }
}
