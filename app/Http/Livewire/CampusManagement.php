<?php

namespace App\Http\Livewire;

use App\Models\Campus;
use Livewire\Component;
use Livewire\WithPagination;

class CampusManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $name = '';
    public $editId = null;
    public $isEditMode = false;
    public $manage_modal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function resetForm()
    {
        $this->name = '';
        $this->editId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        $campuses = Campus::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.campus-management', [
            'campuses' => $campuses,
        ]);
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->manage_modal = true;
    }

    public function openEditModal($id)
    {
        $campus = Campus::findOrFail($id);
        $this->editId = $campus->id;
        $this->name = $campus->name;
        $this->isEditMode = true;
        $this->manage_modal = true;
    }

    public function createCampus()
    {
        $this->validate();

        Campus::create(['name' => $this->name]);

        session()->flash('message', 'Campus created successfully!');
        $this->manage_modal = false;
        $this->resetForm();
    }

    public function updateCampus()
    {
        $this->validate();

        $campus = Campus::findOrFail($this->editId);
        $campus->update(['name' => $this->name]);

        session()->flash('message', 'Campus updated successfully!');
        $this->manage_modal = false;
        $this->resetForm();
    }

    public function deleteCampus($id)
    {
        Campus::findOrFail($id)->delete();

        session()->flash('message', 'Campus deleted successfully!');
        $this->resetForm();
    }
}
