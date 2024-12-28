<?php

namespace App\Http\Livewire;

use App\Models\Permit;
use Livewire\Component;

class PermitLayout extends Component
{   

    public $permit;

    public function mount()
    {   

        $permit = Permit::findOrFail(28);
        $this->permit = $permit;
    }

    public function render()
    {
        return view('livewire.permit-layout');
    }
}
