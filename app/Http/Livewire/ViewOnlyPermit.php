<?php

namespace App\Http\Livewire;

use App\Models\Permit;
use Livewire\Component;

class ViewOnlyPermit extends Component
{

    public $permit;

    public function mount(Permit $permit)
    {
        $this->permit = $permit;
    }

    public function render()
    {
        return view('livewire.view-only-permit');
    }
}
