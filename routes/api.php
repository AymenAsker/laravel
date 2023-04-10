<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Customer\SocialLoginController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Provider\ProviderServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/admin', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(PublicServiceController::class)->group(function () {
    Route::get('category', 'category');
    Route::get('serviceByCategory/{slug}', 'serviceByCategory');
    Route::get('providerServiceByService/{slug}', 'providerServiceByService');
    Route::get('providerServiceByFavorite', 'providerServiceByFavorite');
    Route::post('createFavorite', 'createFavorite');
    Route::post('ratingProvider', 'ratingProvider');
    Route::delete('deleteFavorite/{provider_service_id}', 'deleteFavorite');
});


Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::controller(CategoryController::class)->group(function () {
        Route::get('getAllCategory', 'index');
        Route::post('createCategory', 'store');
        Route::put('updateCategory/{slug}', 'update');
        Route::delete('deleteCategory/{slug}', 'destroy');
        Route::get('sortCategory/{slug}/{type}', 'sort');
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::get('getAllService', 'index');
        Route::get('servicesByCategory', 'servicesByCategory');
        Route::post('createService', 'store');
        Route::put('updateService/{slug}', 'update');
        Route::delete('deleteService/{slug}', 'destroy');
        Route::get('sortService/{slug}/{type}', 'sort');
    });

    Route::controller(ProviderServiceController::class)->group(function () {
        Route::put('updateStatusAProviderService/{slug}', 'updateStatusA');
        Route::put('updateStatusProviderService/{slug}', 'updateStatus');
    });

    Route::controller(ProviderController::class)->group(function () {
        Route::get('getAllProvider', 'index');
        Route::put('updateProviderInAdmin/{id}', 'updateInAdmin');
    });
});

Route::middleware('auth:sanctum')->prefix('provider')->group(function () {

    Route::controller(ProviderServiceController::class)->group(function () {
        Route::get('getAllProviderService', 'index');
        Route::get('servicesByCategory', 'servicesByCategory');
        Route::get('getAuthProviderService', 'getAuthProviderService');
        Route::post('createProviderService', 'store');
        Route::put('updateProviderService/{slug}', 'update');
        Route::put('updateStatusProviderService/{slug}', 'updateStatus');
        Route::delete('deleteProviderService/{slug}', 'destroy');
    });

    Route::controller(PublicServiceController::class)->group(function () {
        Route::get('category', 'category');
        Route::get('serviceByCategory/{slug}', 'serviceByCategory');
        Route::get('providerServiceByService/{slug}', 'providerServiceByService');
        Route::get('providerServicesSearch', 'providerServicesSearch');
        Route::get('providerServiceByFavorite', 'providerServiceByFavorite');
        Route::post('createFavorite', 'createFavorite');
        Route::post('ratingProvider', 'ratingProvider');
        Route::delete('deleteFavorite/{provider_service_id}', 'deleteFavorite');
    });

});

Route::prefix('customer')->group(function () {

    Route::controller(SocialLoginController::class)->group(function () {
        Route::get('auth/{provider}/redirect', 'redirect');
        Route::get('auth/{provider}/callback', 'callback');
        Route::get('auth/facebook/dataDeletionCallback', 'dataDeletionCallback');
    });
});
