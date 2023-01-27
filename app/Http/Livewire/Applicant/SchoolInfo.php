<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\SchoolInformation;
use WireUi\Traits\Actions;
class SchoolInfo extends Component
{
    use Actions;
    public  $school_graduated,$year_graduated,$school_last_attended,$year_last_attended,$previous_school_address,$track_and_strand_taken,$honor_or_awards_received;
    public $school_information;
    public $haspersonalinformation;
    protected $listeners = ['piUpdated'=>'$refresh','done-all'=>'$refresh'];
    public function mount()
    {
        if ($this->haspersonalinformation) {
            $this->loadSchoolInformation();
        }
    }
    
    public function render()
    {
        return view('livewire.applicant.school-info',[
            'applicant_is_freshmen'=>auth()->user()->type_id==1 ? true : false,
            'applicant_is_transferee'=>auth()->user()->type_id==2 ? true : false,
        ]);
    }

    public function loadSchoolInformation()
    {
        $this->school_information = SchoolInformation::where('user_id',auth()->user()->id)->first();
        if($this->school_information){
            $this->school_graduated = $this->school_information->school_graduated;
            $this->year_graduated = $this->school_information->year_graduated;
            $this->school_last_attended = $this->school_information->school_last_attended;
            $this->year_last_attended = $this->school_information->year_last_attended;
            $this->previous_school_address = $this->school_information->previous_school_address;
            $this->track_and_strand_taken = $this->school_information->track_and_strand_taken;
            $this->honor_or_awards_received = $this->school_information->honor_or_awards_received;
        }
    }

    public function save()
    {
        $this->validate([
            'school_graduated'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'year_graduated'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'track_and_strand_taken'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'honor_or_awards_received'=>auth()->user()->type_id ==1 ? 'nullable' : 'nullable',
            'school_last_attended'=>auth()->user()->type_id ==2 ? 'required' : 'nullable',
            'year_last_attended'=>auth()->user()->type_id ==2 ? 'required' : 'nullable',
            'previous_school_address'=>'required',
        ]);
        SchoolInformation::create([
            'user_id'=>auth()->user()->id,
            'school_graduated'=>$this->school_graduated,
            'year_graduated'=>$this->year_graduated,
            'school_last_attended'=>$this->school_last_attended,
            'year_last_attended'=>$this->year_last_attended,
            'previous_school_address'=>$this->previous_school_address,
            'track_and_strand_taken'=>$this->track_and_strand_taken,
            'honor_or_awards_received'=>$this->honor_or_awards_received,
        ]);

        $this->dispatchBrowserEvent('done-si');
        $this->emit('siUpdated');

        $this->notification([
            'title'=>'Success',
            'description'=>'Personal Information has beed added',
            'icon'=>'success',
        ]);

        $this->loadSchoolInformation();
    }

    public function update()
    {
        $this->validate([
            'school_graduated'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'year_graduated'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'track_and_strand_taken'=>auth()->user()->type_id ==1 ? 'required' : 'nullable',
            'honor_or_awards_received'=>auth()->user()->type_id ==1 ? 'nullable' : 'nullable',
            'school_last_attended'=>auth()->user()->type_id ==2 ? 'required' : 'nullable',
            'year_last_attended'=>auth()->user()->type_id ==2 ? 'required' : 'nullable',
            'previous_school_address'=>'required',
        ]);
        $this->school_information->update([
            'school_graduated'=>$this->school_graduated,
            'year_graduated'=>$this->year_graduated,
            'school_last_attended'=>$this->school_last_attended,
            'year_last_attended'=>$this->year_last_attended,
            'previous_school_address'=>$this->previous_school_address,
            'track_and_strand_taken'=>$this->track_and_strand_taken,
            'honor_or_awards_received'=>$this->honor_or_awards_received,
        ]);
        $this->dispatchBrowserEvent('done-si');
        $this->emit('siUpdated');
        $this->notification([
            'title'=>'Success',
            'description'=>'Personal Information has beed updated',
            'icon'=>'success',
        ]);
        $this->loadSchoolInformation();
    }

    
}
