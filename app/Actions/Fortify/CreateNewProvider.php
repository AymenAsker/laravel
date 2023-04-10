<?php

namespace App\Actions\Fortify;


use App\Models\Provider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewProvider implements CreatesNewUsers
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

        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:40'],
            'last_name' => ['required', 'string', 'max:40'],
            'phone_number' => ['required', 'string', 'regex:/^(092|091|094)+[0-9]{7}$/',Rule::unique(Provider::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return Provider::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
