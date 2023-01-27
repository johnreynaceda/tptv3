<?php

namespace App\Http\Livewire\Admin\Examination;

use Livewire\Component;
use App\Models\Examination;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Table extends Component
{
    use WithPagination, Actions;
    public $search='';
    protected $listeners = ['refresh' => '$refresh'];
    public $examination_id;
    public function render()
    {
        return view('livewire.admin.examination.table',[
            'examinations'=>Examination::query()
                                        ->where('title','like','%'.$this->search.'%')
                                        ->paginate(10)
        ]);
    }

    public function edit($id)
    {
        $this->emit('edit',$id);
        $this->dispatchBrowserEvent('edit');
    }

    public function delete($id)
    {
        $this->examination_id=$id;
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'You are about to delete this examination',
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
        Examination::find($this->examination_id)->delete();
        $this->notification([
            'title' => 'Success',
            'description' => 'Examination deleted successfully',
            'icon' => 'success',
        ]);
    }

    public function activate($id)
    {
        $this->examination_id=$id;
         $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'You are about to activate this examination',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Activate it',
                'method' => 'confirmActivate',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmActivate()
    {
        Examination::where('is_active',true)->update(['is_active'=>false]);
        Examination::find($this->examination_id)->update(['is_active'=>true]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Examination activated successfully',
            'icon' => 'success',
        ]);
    }

    public function deactivate($id)
    {
        $this->examination_id=$id;
         $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'You are about to deactivate this examination',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, Deactivate it',
                'method' => 'confirmDeactivate',
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmDeactivate()
    {
        Examination::find($this->examination_id)->update(['is_active'=>false]);
        $this->notification([
            'title' => 'Success',
            'description' => 'Examination deactivated successfully',
            'icon' => 'success',
        ]);
    }
}
