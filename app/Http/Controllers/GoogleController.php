<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    

    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callBack()
{
    $google_user = Socialite::driver('google')->user();

    
    $usedAsCredentials = User::where('email', $google_user->email)
                              ->where('provider', 'CREDENTIALS')
                              ->exists();

    if ($usedAsCredentials) {
        return redirect()->route('login')->withErrors([
            'email' => 'This email is already associated with a non-Google account. Please use your credentials to log in.'
        ]);
    }

  
    $nameParts = explode(' ', $google_user->name, 2);
    $first_name = $nameParts[0];
    $last_name = isset($nameParts[1]) ? $nameParts[1] : '';

  
    $user = User::updateOrCreate([
        'email' => $google_user->email,
    ], [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'provider' => 'GOOGLE',
        'provider_id' => $google_user->id,
        'email_verified_at' => now(),
        'password' => null,
    ]);

    // Log the user in
    Auth::login($user);

    return redirect('/');
}

}
