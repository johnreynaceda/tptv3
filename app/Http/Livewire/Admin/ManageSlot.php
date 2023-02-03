<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\TestCenter;
use App\Models\Slot;
use WireUi\Traits\Actions;
use DB;

class ManageSlot extends Component
{
    use Actions;
    public $examination;
    public $manage_modal = false;
    public $test_center;
    public $slots;
    public $rooms;
    public $building_name;
    public $date;
    public $is_edit = false;
    public $slot_id;
    public function render()
    {
        return view('livewire.admin.manage-slot', [
            'campuses' => Campus::all(),
            'centers' => TestCenter::where('examination_id', $this->examination)
                ->with(['campus', 'slots'])
                ->get(),
        ]);
    }

    public function openAddModal()
    {
        $this->manage_modal = true;
        $this->is_edit = false;
    }

    public function openUpdateModal($id)
    {
        $this->manage_modal = true;
        $this->is_edit = true;

        $slot = Slot::where('id', $id)->first();
        $this->slot_id = $slot->id;
        $this->test_center = $slot->test_center->campus_id;
        $this->date = $slot->date_of_exam;
        $this->building_name = $slot->building_name;
        $this->slots = $slot->slots;
        $this->rooms = $slot->number_of_rooms;
    }

    public function addSlot()
    {
        $this->validate([
            'test_center' => 'required',
            'date' => 'required',
            'slots' => 'required|numeric',
            'rooms' => 'required|numeric',
        ]);
        DB::beginTransaction();
        $test_center = TestCenter::create([
            'examination_id' => $this->examination,
            'campus_id' => $this->test_center,
        ]);

        Slot::create([
            'test_center_id' => $test_center->id,
            'date_of_exam' => $this->date,
            'building_name' => $this->building_name,
            'slots' => $this->slots,
            'number_of_rooms' => $this->rooms,
        ]);
        DB::commit();
        $this->reset('test_center', 'slots', 'rooms');
    }

    public function editSlot()
    {
        $this->validate([
            'test_center' => 'required',
            'date' => 'required',
            'building_name' => 'required',
            'slots' => 'required|numeric',
            'rooms' => 'required|numeric',
        ]);

        DB::beginTransaction();
        $test_center = Slot::where('id', $this->slot_id)->first();
        $test_center->update([
            'test_center_id' => $test_center->id,
            'date_of_exam' => $this->date,
            'building_name' => $this->building_name,
            'slots' => $this->slots,
            'number_of_rooms' => $this->rooms,
        ]);

        DB::commit();
        $this->manage_modal = false;
        $this->reset('test_center', 'building_name', 'date', 'slots', 'rooms');
    }

    public function deactivateSched($id)
    {
        $this->slot_id = $id;
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you really want to deactivate this schedule?',
            'acceptLabel' => 'Yes, deactivate it.',
            'method'      => 'deactivateSchedule',
            'params'      => 'Saved',
        ]);
    }

    public function deactivateSchedule()
    {
        DB::beginTransaction();
        $test_center = Slot::where('id', $this->slot_id)->first();
        $test_center->update([
            'is_active' => 0,
        ]);
        DB::commit();
    }

    public function activateSched($id)
    {
        $this->slot_id = $id;
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you really want to activate this schedule?',
            'acceptLabel' => 'Yes, activate it.',
            'method'      => 'activateSchedule',
            'params'      => 'Saved',
        ]);
    }

    public function activateSchedule()
    {
        DB::beginTransaction();
        $test_center = Slot::where('id', $this->slot_id)->first();
        $test_center->update([
            'is_active' => 1,
        ]);
        DB::commit();
    }
}
