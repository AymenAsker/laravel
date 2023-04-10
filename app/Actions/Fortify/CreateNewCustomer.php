<?php

namespace App\Actions\Fortify;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewCustomer implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array<string, string> $input
     */
    public function create(array $input): Customer
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:30'],
            'username' => [
                'required',
                'string',
                'max:20',
                Rule::unique(Customer::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return Customer::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
