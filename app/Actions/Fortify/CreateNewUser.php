<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $usedAsCredentials = User::where('email', $input['email'])
            ->where('provider', 'CREDENTIALS') // Check for provider 'CREDENTIALS'
            ->exists();

        if ($usedAsCredentials) {
            // Throw a validation exception with a user-friendly error message
            throw ValidationException::withMessages([
                'email' => 'This email is already associated with a non-Google account. Please use your credentials to log in.',
            ]);
        }
        
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255', Rule::unique('users')->where(function ($query) use ($input) {
                return $query->where('first_name', $input['first_name'])
                            //  ->where('middle_name', $input['middle_name'] ?? '')
                             ->where('last_name', $input['last_name']);
            })],
            // 'middle_name' => ['nullable', 'string', 'max:255', Rule::unique('users')->where(function ($query) use ($input) {
            //     return $query->where('first_name', $input['first_name'])
            //                  ->where('middle_name', $input['middle_name'] ?? '')
            //                  ->where('last_name', $input['last_name']);
            // })],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255', Rule::unique('users')->where(function ($query) use ($input) {
                return $query->where('first_name', $input['first_name'])
                            //  ->where('middle_name', $input['middle_name'] ?? '')
                             ->where('last_name', $input['last_name']);
            })],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();


        return User::create([
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
