<?php

namespace App\Http\Livewire\Admin\Applications;

use Livewire\Component;
use App\Models\{Examination,User};
class View extends Component
{
    protected $listeners = [
        'loadUserInfo',
    ];
    public $user;
    public function render()
    {
        return view('livewire.admin.applications.view');
    }

    public function loadUserInfo($id)
    {
        $this->user = User::query()
                            ->where('id', $id)
                            ->with(['personal_information',
                                    'school_information',
                                    'program_choices'=>[
                                        'program'
                                    ],
                                ])
                            ->first();
    }

}
