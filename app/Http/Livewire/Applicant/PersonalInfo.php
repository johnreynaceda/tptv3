<?php

namespace App\Http\Livewire\Applicant;

use Livewire\Component;
use App\Models\PersonalInformation;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
class PersonalInfo extends Component
{
    use Actions, WithFileUploads;
    public $type_id,$first_name, $middle_name,$last_name,$extension,$present_address,$permanent_address,$phone_number,$date_of_birth,$place_of_birth,$age,$tribe,$religion,$nationality,$citizenship,$photo,$sex;
    public $personal_information;
    protected $rules = [
        'type_id'=>'required|in:1,2',
        'first_name'=>'required',
        'middle_name'=>'nullable',
        'last_name'=>'required',
        'extension'=>'nullable',
        'present_address'=>'required',
        'permanent_address'=>'required',
        'phone_number'=>'required',
        'date_of_birth'=>'required',
        'place_of_birth'=>'required',
        'age'=>'required|gte:16',
        'tribe'=>'required',
        'religion'=>'required',
        'nationality'=>'required',
        'citizenship'=>'nullable',
        'photo'=>'required|image|mimes:png,jpg|max:100000',
        'sex'=>'required',
    ];
    protected $validationAttributes=['type_id'=>'type'];
    protected $listeners = ['done-all'=>'$refresh'];
    public function mount()
    {
        $this->loadPersonalInformation();
    }

    public function render()
    {
        return view('livewire.applicant.personal-info');
    }

    public function updatedDateOfBirth()
    {
        $birthday = new \Carbon\Carbon($this->date_of_birth);
        $this->age = \Carbon\Carbon::now()->diffInYears($birthday);
    }

    public function create()
    {
        $this->validate();
        PersonalInformation::create([
            'user_id'=>auth()->user()->id,
            'type_id'=>$this->type_id,
            'first_name'=>$this->first_name,
            'middle_name'=>$this->middle_name,
            'last_name'=>$this->last_name,
            'extension'=>$this->extension,
            'present_address'=>$this->present_address,
            'permanent_address'=>$this->permanent_address,
            'phone_number'=>$this->phone_number,
            'date_of_birth'=>$this->date_of_birth,
            'place_of_birth'=>$this->place_of_birth,
            'age'=>$this->age,
            'tribe'=>$this->tribe,
            'religion'=>$this->religion,
            'nationality'=>$this->nationality,
            'citizenship' => $this->nationality,
            'photo' => $this->photo->store('photos','public'),
            'sex' => $this->sex,
        ]);
        auth()->user()->update([
            'type_id'=>$this->type_id,
        ]);
        $this->dispatchBrowserEvent('done-pi');
        $this->emit('piUpdated');
        $this->notification([
            'title'=>'Success',
            'description'=>'Personal Information has beed added',
            'icon'=>'success',
        ]);

        $this->loadPersonalInformation();
    }
    public function update()
    {
        $personal_information = PersonalInformation::where('user_id',auth()->user()->id)->first();
        $this->validate([
            'type_id'=>'required|in:1,2',
            'first_name'=>'required',
            'middle_name'=>'nullable',
            'last_name'=>'required',
            'extension'=>'nullable',
            'present_address'=>'required',
            'permanent_address'=>'required',
            'phone_number'=>'required',
            'date_of_birth'=>'required',
            'place_of_birth'=>'required',
            'age'=>'required|gte:16',
            'tribe'=>'required',
            'religion'=>'required',
            'nationality'=>'required',
            'citizenship'=>'nullable',
            'photo'=> 'nullable',
            'sex'=>'required',
        ]);
        $personal_information->update([
            'type_id'=>$this->type_id,
            'first_name'=>$this->first_name,
            'middle_name'=>$this->middle_name,
            'last_name'=>$this->last_name,
            'extension'=>$this->extension,
            'present_address'=>$this->present_address,
            'permanent_address'=>$this->permanent_address,
            'phone_number'=>$this->phone_number,
            'date_of_birth'=>$this->date_of_birth,
            'place_of_birth'=>$this->place_of_birth,
            'age'=>$this->age,
            'tribe'=>$this->tribe,
            'religion'=>$this->religion,
            'nationality'=>$this->nationality,
            'citizenship' => $this->nationality,
            'photo' => $this->photo ? $this->photo->store('photos','public') : $personal_information->photo,
            'sex' => $this->sex,
        ]);
        auth()->user()->update([
            'type_id'=>$this->type_id,
        ]);
        $this->dispatchBrowserEvent('done-pi');
        $this->emit('piUpdated');
        $this->notification([
            'title'=>'Success',
            'description'=>'Personal Information has beed updated',
            'icon'=>'success',
        ]);
        $this->loadPersonalInformation();

    }
    public function loadPersonalInformation()
    {
        $this->first_name = auth()->user()->first_name;
        $this->middle_name = auth()->user()->middle_name;
        $this->last_name = auth()->user()->last_name;
        $this->personal_information= PersonalInformation::where('user_id',auth()->user()->id)->first();
        if ($this->personal_information) {
            $this->type_id = $this->personal_information->type_id;
            $this->first_name = $this->personal_information->first_name;
            $this->middle_name = $this->personal_information->middle_name;
            $this->last_name = $this->personal_information->last_name;
            $this->extension = $this->personal_information->extension;
            $this->present_address = $this->personal_information->present_address;
            $this->permanent_address = $this->personal_information->permanent_address;
            $this->phone_number = $this->personal_information->phone_number;
            $this->date_of_birth = $this->personal_information->date_of_birth;
            $this->place_of_birth = $this->personal_information->place_of_birth;
            $this->age = $this->personal_information->age;
            $this->tribe = $this->personal_information->tribe;
            $this->religion = $this->personal_information->religion;
            $this->nationality = $this->personal_information->nationality;
            // $this->citizenship = $this->personal_information->nationality;
            $this->sex = $this->personal_information->sex;
        }
    }
}
