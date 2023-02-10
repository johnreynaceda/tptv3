<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User as UserModel;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Hash;
use DB;

class User extends Component
{
    use Actions;
    public $search;
    public $user, $information;
    public function render()
    {
        if($this->search == "" && $this->search == null)
        {
            $this->user = null;
            $this->information = null;
        }else{
            $this->user = UserModel::where('name', 'like', '%'.$this->search .'%')
            ->orWhere('email', 'like', '%'.$this->search .'%')
            ->whereHas('personal_information')->first();
            if($this->user != null )
            {
                $this->information = $this->user->personal_information;
            }else{
                $this->information = null;
            }
            
        }

        return view('livewire.admin.user', [
            'user' => $this->user,
            'info' => $this->information,
        ]);
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
