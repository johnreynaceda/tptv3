<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
use App\Models\StudentSlot;
use App\Models\Slot;
use App\Models\TestCenter;
class Monitoring extends Component
{
    use WithPagination;
    public $date;
    public $test_center;
    public $time;
    public $student_slot_modal = false;
    public function render()
    {
        return view('livewire.admin.monitoring', [
            'student_slots' => StudentSlot::when($this->time, function (
                $query
            ) {
                $query->where('time', $this->time);
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
                })

                ->get()
                ->groupBy('room_number'),
            'test_centers' => TestCenter::whereHas('slots', function ($slot) {
                $slot->when($this->date, function ($query) {
                    $query->where('date_of_exam', $this->date);
                });
            })
                ->with(['campus', 'slots'])
                ->get(),
            'dates' => Slot::get()
                ->pluck('date_of_exam')
                ->unique(),
            'student_slot_details' => StudentSlot::when($this->time, function (
                $query
            ) {
                $query->where('time', $this->time);
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

    public function updateSlots()
    {
        $slots = StudentSlot::when($this->time, function (
            $query
        ) {
            $query->where('time', $this->time);
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
            })->get();
            $roomNumber = 1;
            $seatNumber = 1;
            foreach ($slots as $slot)
            {
            $slot->room_number = $roomNumber;
            $slot->seat_number = $seatNumber;
            $slot->save();
            
            $seatNumber++;
            if ($seatNumber > 50)
            {
                $roomNumber++;
                $seatNumber = 1;
            }
            }
    }
}
