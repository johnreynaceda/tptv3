<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\Actions;

class ForgotPassword extends Component
{
    use Actions;
    public $email;
    public $new_password;
    public $confirm_password;

    public function resetPassword()
    {

        $this->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = User::where('email', $this->email)->where('id', '!=', 1)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($this->new_password),
            ]);

            $this->dialog()->success(
                $title = 'Password Changed.',
                $description = 'Your password has been changed successfully.'
            );
            return redirect()->route('login');
        } else {
            $this->dialog()->error(
                $title = 'Oops! Something went wrong.',
                $description = 'We could not find any user with this email.'
            );


        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
