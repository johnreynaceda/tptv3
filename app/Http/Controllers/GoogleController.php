<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    

    public function redirect(){
        return Socialite::driver('google') 
        ->with(['prompt' => 'select_account']) // Add this line
        ->stateless()
        
        ->redirect();
    }

    public function callBack()
{
    // $google_user = Socialite::driver('google')->user();

    
    // $usedAsCredentials = User::where('email', $google_user->email)
    //                           ->where('provider', 'CREDENTIALS')
    //                           ->exists();

    // if ($usedAsCredentials) {
    //     return redirect()->route('login')->withErrors([
    //         'email' => 'This email is already associated with a non-Google account. Please use your credentials to log in.'
    //     ]);
    // }

  
    // $nameParts = explode(' ', $google_user->name, 2);
    // $first_name = $nameParts[0];
    // $last_name = isset($nameParts[1]) ? $nameParts[1] : '';

  
    // $user = User::updateOrCreate([
    //     'email' => $google_user->email,
    // ], [
    //     'first_name' => $first_name,
    //     'last_name' => $last_name,
    //     'provider' => 'GOOGLE',
    //     'provider_id' => $google_user->id,
    //     'email_verified_at' => now(),
    //     'password' => null,
    // ]);

    // // Log the user in
    // Auth::login($user);

    // return redirect()->route('dashboard');

    $google_user = Socialite::driver('google')->stateless()->user(); // Add stateless() here

    // Extract first and last name from Google user data
    $nameParts = explode(' ', $google_user->name, 2);
    $first_name = $nameParts[0];
    $last_name = $nameParts[1] ?? '';

    // Create or update the user without restrictions
    $user = User::updateOrCreate([
        'email' => $google_user->email,
    ], [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'provider' => 'GOOGLE', // Update provider to Google
        'provider_id' => $google_user->id,
        'email_verified_at' => now(),
        'password' => null, // No password required for OAuth users
    ]);

    // Log the user in
    Auth::login($user);

    return redirect()->route('dashboard');
}

}
