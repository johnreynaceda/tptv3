<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\ProgramChoice;
use WireUi\Traits\Actions;
class ProgramInfo extends Component
{
    use Actions;
    public $campuses=[];
    public $first_priority_program,$second_priority_program;
    public $first;
    public $second;
    public $f_program_name;
    public $s_program_name;
    protected $listeners = ['piUpdated'=>'$refresh'];

    public function mount()
    {
        $this->campuses = \App\Models\Campus::with('programs')->get();
        $this->loadProgramInformation();
    }

    public function render()
    {
        return view('livewire.applicant.program-info');
    }
    public function updatedFirstPriorityProgram()
    {
        if ($this->first) {
            $this->first->update([
                'program_id'=>$this->first_priority_program,
            ]);
            $this->notification([
                'title'=>'Success',
                'description'=>'First Priority Program has been updated',
                'icon'=>'success',
            ]);
        }else{
            ProgramChoice::create([
                'user_id'=>auth()->user()->id,
                'program_id'=>$this->first_priority_program,
                'is_priority'=>1,
            ]);
            $this->notification([
                'title'=>'Success',
                'description'=>'First Priority Program has been set',
                'icon'=>'success',
            ]);
          
        }
          $this->loadProgramInformation();
            if (auth()->user()->type_id == 2) {
                $this->dispatchBrowserEvent('done-pc');
            }
    }

    public function updatedSecondPriorityProgram()
    {
        if ($this->second) {
            $this->second->update([
                'program_id'=>$this->second_priority_program,
            ]);
            $this->notification([
                'title'=>'Success',
                'description'=>'Second Priority Program has been updated',
                'icon'=>'success',
            ]);
        }else{
            ProgramChoice::create([
                'user_id'=>auth()->user()->id,
                'program_id'=>$this->second_priority_program,
                'is_priority'=>0,
            ]);
            $this->notification([
                'title'=>'Success',
                'description'=>'Second Priority Program has been set',
                'icon'=>'success',
            ]);
        }
        $this->loadProgramInformation();
    }

    public function loadProgramInformation()
    {
        $programs = ProgramChoice::where('user_id',auth()->user()->id)->get();
        $this->first = $programs?->where('is_priority',1)->first();
        $this->second = $programs?->where('is_priority',0)->first();
        $this->first_priority_program = $this->first?->program_id;
        $this->second_priority_program = $this->second?->program_id;
        $this->f_program_name = $this->first?->program->name;
        $this->s_program_name = $this->second?->program->name;
    }

    public function submutApplication()
    {
        if (!$personal_information = auth()->user()->personal_information) {
            $this->notification([
                'title'=>'Error',
                'description'=>'Please fill up your personal information first',
                'icon'=>'error',
            ]);
            return;
        }

        if (!$school_information = auth()->user()->school_information) {
            $this->notification([
                'title'=>'Error',
                'description'=>'Please fill up your school information first',
                'icon'=>'error',
            ]);
            return;
        }
        $program_choices = ProgramChoice::where('user_id',auth()->user()->id)->get();
        if (auth()->user()->type_id==1) {
            if ($program_choices->count() < 2) {
                $this->notification([
                    'title'=>'Error',
                    'description'=>'Please select at least 2 programs',
                    'icon'=>'error',
                ]);
                return;
            }
        }else{
            if ($program_choices->count() < 1) {
                $this->notification([
                    'title'=>'Error',
                    'description'=>'Please select at least 1 program',
                    'icon'=>'error',
                ]);
                return;
            }
        }
        
        auth()->user()->application->update([
            'submited_at'=>now(),
            'status'=>'submitted',
        ]);
        auth()->user()->update([
            'step'=>'3'
        ]);
        $this->notification([
            'title'=>'Success',
            'description'=>'Application has been submited. Please proceed to payment',
            'icon'=>'success',
        ]); 

        $this->dispatchBrowserEvent('done-all');
        return redirect()->route('applicant.payment');
    }
    
}
