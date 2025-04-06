<?php

namespace App\Http\Livewire\Admin\Applications;

use Livewire\Component;
use App\Models\{Examination, Application, User};
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    public $examination;
    public $step = ['4', '5'], $search = '';
    public $type = '';
    protected $listeners = [
        'refresh' => '$refresh',
        'refreshTable' => '$refresh', // Li
    ];
    public function render()
    {

        // $applications = Application::query()
        // ->when($this->type, function ($query) {
        //     $query->whereHas('user.personal_information', function ($query) {
        //         $query->where('type_id', $this->type);
        //     });
        // })
        // ->with(['user' => [
        //     'personal_information',
        //     'school_information',
        //     'program_choices' => [
        //         'program'
        //     ]
        // ], 'user.permit'])
        // ->where('applications.examination_id', 1) // Qualify `examination_id`
        // ->orderByExamineeNumber()
        // ->paginate(10);
        // return view('livewire.admin.applications.table', compact('applications'));



        // return view('livewire.admin.applications.table', [
        //     'applications' => Application::query()
        //         ->where('examination_id', $this->examination)
        //         ->whereHas('user', function ($query) {
        //             $query->whereIn('step', $this->step);
        //         })
                
        //         ->when($this->search, function ($query) {
        //             $query->whereHas('user.personal_information', function ($query) {
        //                 $query->where('first_name', 'like', '%' . $this->search . '%')
        //                     ->orWhere('last_name', 'like', '%' . $this->search . '%');
        //             });
        //         })
        //         ->when($this->type, function ($query) {
        //             $query->whereHas('user.personal_information', function ($query) {
        //                 $query->where('type_id', $this->type);
        //             });
        //         })
        //         ->with(['user' => [
        //             'personal_information',
        //             'school_information',
        //             'program_choices' => [
        //                 'program'
        //             ],

        //         ],'user.permit'])
        //         // ->orderByExamineeNumber()
        //         ->paginate(10),
        // ]);

        return view('livewire.admin.applications.table', [
            'applications' => Application::query()
                ->where('applications.examination_id', $this->examination)
                ->whereHas('user', function ($query) {
                    $query->whereIn('step', $this->step);
                })
                ->whereHas('user.personal_information')
                ->when($this->search, function ($query) {
                    $query->whereHas('user.personal_information', function ($query) {
                        $query->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->type, function ($query) {
                    $query->whereHas('user.personal_information', function ($query) {
                        $query->where('type_id', $this->type);
                    });
                })
                ->with([
                    'user' => [
                        'personal_information',
                        'school_information',
                        'program_choices' => function($query) {
                            $query->with('program')->orderBy('is_priority', 'desc');
                        },
                    ],
                    'user.permit',
                ])
                ->leftJoin('users', 'applications.user_id', '=', 'users.id')
                ->leftJoin('permits', 'users.id', '=', 'permits.user_id')
                ->select('applications.*')
                ->orderByRaw('CASE WHEN permits.examinee_number IS NULL THEN 1 ELSE 0 END')
                ->orderByRaw('CAST(permits.examinee_number AS UNSIGNED) ASC')
                ->paginate(10),
        ]);
        


        
        
    }

    public function select($id)
    {
        $this->dispatchBrowserEvent('view-payment');
        $this->emit('loadUserPayment', $id);
    }

    public function viewInfo($id)
    {
        $this->dispatchBrowserEvent('view-info');
        $this->emit('loadUserInfo', $id);
    }
}
