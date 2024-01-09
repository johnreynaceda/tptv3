<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Examination;
use App\Models\Slot;
use App\Models\TestCenter;
use App\Models\StudentSlot;
use App\Models\Permit;

class Report extends Component
{
    public $exam;
    public $date;
    public $time;
    public $test_center;
    public $rooms;
    public $campus_name;
    public $building_name;
    public function render()
    {
        if($this->test_center != null && $this->test_center != 'Select Testing Center')
        {
            $this->building_name = Slot::where('test_center_id', $this->test_center)->first()->building_name;
            $this->campus_name = Slot::where('test_center_id', $this->test_center)->first()->test_center->campus->name;
        }else{
            $this->building_name = '';
            $this->campus_name = '';
        }
        return view('livewire.admin.report', [
            'examinations' => Examination::where('is_active', true)->get(),
            'dates' => Slot::get()
                ->pluck('date_of_exam')
                ->unique(),
            'test_centers' => TestCenter::whereHas('slots', function ($slot) {
                $slot->when($this->date, function ($query) {
                    $query->where('date_of_exam', $this->date);
                });
                })
                ->with(['campus', 'slots'])
                ->get(),
            'student_slot_details' => StudentSlot::when($this->time, function (
                    $query
                ) {
                    $query->where('time', $this->time);
                })
                ->when($this->rooms, function ($query) {
                    $query->where('room_number', $this->rooms);
                })
                    ->whereHas('slot', function ($slot) {
                        $slot
                            ->whereHas('test_center', function ($center) {
                                $center->when($this->test_center, function (
                                    $query
                                ) {
                                    $query->where('id', $this->test_center);
                                });
                            })
                            ->when($this->date, function ($query) {
                                $query->where('date_of_exam', $this->date);
                            });
                    })->get(),

        ]);
    }

    public function updateExamineeNumbers()
    {
        $permits = Permit::all();

        // Update each record
        foreach ($permits as $permit) {
            // Update the examinee_number field
            $permit->examinee_number = str_pad($permit->user->id, 4, '0', STR_PAD_LEFT);

            // Save the changes
            $permit->save();
        }
    }
}
