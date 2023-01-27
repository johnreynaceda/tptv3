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
}
