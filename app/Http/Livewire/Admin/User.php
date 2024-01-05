<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User as UserModel;
use App\Models\PersonalInformation;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Hash;
use DB;

class User extends Component
{
    use Actions;
    public $search;
    public $user, $info;
    public $informations;
    public $studentModal = false;
    public $student_id;
    public function render()
    {
        if($this->search == "" && $this->search == null)
        {
            $this->informations = null;
        }else{
            $this->informations = PersonalInformation::whereHas('user', function($query){
                $query->where('first_name', 'like', '%'.$this->search .'%')
                ->orWhere('last_name', 'like', '%'.$this->search .'%')
                ->orWhere('email', 'like', '%'.$this->search .'%');
            })->get();
        }

        return view('livewire.admin.user', [
            'informations' => $this->informations,
        ]);
    }

    public function openStudentModal($id)
    {
        $this->student_id = $id;
        $this->user = UserModel::where('id', $this->student_id)->first();
        $this->info = PersonalInformation::where('user_id', $this->student_id)->first();
        $this->studentModal = true;
    }

    public function confirmResetPassword()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you really want to reset password?',
            'acceptLabel' => 'Yes, reset it.',
            'method'      => 'resetPassword',
            'params'      => 'Saved',
        ]);
    }

    public function resetPassword()
    {
        DB::beginTransaction();
        $user = UserModel::where('id', $this->user->id)->first();
        $user->password = Hash::make('12345');
        $user->save();
        DB::commit();
        $this->notification()->success(
            $title = 'Password Reset',
            $description = 'Password was successfully reset.'
        );
        return redirect()->route('admin.users');
    }
}
