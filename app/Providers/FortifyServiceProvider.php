<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewAdmin;
use App\Actions\Fortify\CreateNewProvider;
use App\Actions\Fortify\CreateNewCustomer;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateProviderProfileInformation;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('api/admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.username', 'username');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', '/api/admin');
        }
        if ($request->is('api/provider/*')) {
            Config::set('fortify.guard', 'provider');
            Config::set('fortify.username', 'phone_number');
            Config::set('fortify.passwords', 'providers');
            Config::set('fortify.prefix', '/api/provider');
        }
        if ($request->is('api/customer/*')) {
            Config::set('fortify.guard', 'customer');
            Config::set('fortify.username', 'username');
            Config::set('fortify.passwords', 'customers');
            Config::set('fortify.prefix', '/api/customer');
        }

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->user('admin')) {
                    return $request->user('admin');
                }
                if ($request->user('provider')) {
                    return $request->user('provider');
                }
                if ($request->user('customer')) {
                    return $request->user('customer');
                }
//                return $request->user()->load(['subAdministration' => function ($q) {
//                    $q->with('mainAdministration')->get();
//                }]);
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                if ($request->user('admin')) {
                    return $request->user('admin');
                }
                if ($request->user('provider')) {
                    return $request->user('provider');
                }
                if ($request->user('customer')) {
                    return $request->user('customer');
                }
//                return $request->user()->load(['subAdministration' => function ($q) {
//                    $q->with('mainAdministration')->get();
//                }]);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Config::get('fortify.guard') == 'admin') {
//            Fortify::createUsersUsing(CreateNewAdmin::class);
        } elseif (Config::get('fortify.guard') == 'provider') {
            Fortify::createUsersUsing(CreateNewProvider::class);
            Fortify::updateUserProfileInformationUsing(UpdateProviderProfileInformation::class);
        } elseif (Config::get('fortify.guard') == 'customer') {
            Fortify::createUsersUsing(CreateNewCustomer::class);
        } else {
            Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        }
//        Fortify::createUsersUsing(CreateNewCustomer::class);
//        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string)$request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
