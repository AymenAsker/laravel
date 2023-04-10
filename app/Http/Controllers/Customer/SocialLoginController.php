<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return response()->json([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function callback($provider)
    {
        try {
            $provider_customer = Socialite::driver($provider)->stateless()->user();


            $customer = Customer::updateOrCreate([
                'provider' => $provider,
                'provider_id' => $provider_customer->id,
            ], [
                'name' => $provider_customer->name,
                'provider' => $provider,
                'provider_id' => $provider_customer->id,
                'password' => Hash::make(Str::random(8)),
            ]);

            Auth::guard('customer')->login($customer);
//            return redirect()->to(config('app.url_front'));
            return $customer;

        } catch (\Throwable $e) {
            return redirect()->to(config('app.url_front') . '/customer/login');
        }

    }

    public function dataDeletionCallback(Request $request)
    {
        $signed_request = $request->get('signed_request');
        $data = $this->parse_signed_request($signed_request);
        $user_id = $data['user_id'];

        // here will delete the user base on the user_id from facebook
        Customer::where([
            ['provider' => 'facebook'],
            ['provider_id' => $user_id]
        ])->forceDelete();

        // here will check if the user is deleted
        $isDeleted = Customer::withTrashed()->where([
            ['provider' => 'facebook'],
            ['provider_id' => $user_id]
        ])->find();

        if ($isDeleted ===null) {
            return response()->json([
                'url' => config('app.url'), // <------ i dont know what to put on this or what should it do
                'confirmation_code' => Str::random(5), // <------ i dont know what is the logic of this code
            ]);
        }

        return response()->json([
            'message' => 'operation not successful'
        ], 500);
    }
}
