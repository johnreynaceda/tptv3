<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Campus;
use App\Models\TestCenter;
use App\Models\Slot;
use DB;

class ManageSlot extends Component
{
    public $examination;
    public $manage_modal = false;
    public $test_center;
    public $slots;
    public $rooms;
    public $building_name;
    public $date;
    public $is_edit = false;
    public function render()
    {
        return view('livewire.admin.manage-slot', [
            'campuses' => Campus::all(),
            'centers' => TestCenter::where(
                'examination_id',
                $this->examination
            )->get(),
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

        $slot = Slot::find($id);
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
            'slots' => 'required|numeric',
            'rooms' => 'required|numeric',
        ]);
        DB::beginTransaction();
        $test_center = TestCenter::update([
            'examination_id' => $this->examination,
            'campus_id' => $this->test_center,
        ]);

        Slot::update([
            'test_center_id' => $test_center->id,
            'date_of_exam' => $this->date,
            'building_name' => $this->building_name,
            'slots' => $this->slots,
            'number_of_rooms' => $this->rooms,
        ]);
        DB::commit();
        $this->reset('test_center', 'slots', 'rooms');
    }
}
