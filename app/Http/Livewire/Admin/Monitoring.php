<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
class Monitoring extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.admin.monitoring', [
            'applications' => Application::whereNotNull('student_slot_id')
                ->with([
                    'user',
                    'student_slot',
                    'student_slot.slot',
                    'student_slot.slot.test_center.campus',
                ])
                ->paginate(10),
        ]);
    }
}
