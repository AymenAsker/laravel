<?php

namespace App\Actions\Fortify;

use App\Models\Provider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateProviderProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param array<string, string> $input
     */
    public function update(Provider $user, array $input): void
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:40'],
            'last_name' => ['required', 'string', 'max:40'],
            'phone_number' => ['required', 'string', 'regex:/^(092|091|094)+[0-9]{7}$/', Rule::unique('providers')->ignore($user->id)],
        ])->validateWithBag('updateProfileInformation');

        $user->forceFill([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
        ])->save();

        $user->providerServices()->update(['status_a' => 0]);

    }

    /**
     * Update the given verified user's profile information.
     *
     * @param array<string, string> $input
     */
    protected function updateVerifiedUser(Provider $user, array $input): void
    {
        $user->forceFill([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
