<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\Public\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    private ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category()
    {
        return $this->serviceService->category();
    }

    public function serviceByCategory($slug)
    {
        return $this->serviceService->serviceByCategory($slug);
    }

    public function providerServiceByService($slug)
    {
        return $this->serviceService->providerServiceByService($slug);
    }

    public function providerServicesSearch(Request $request)
    {
        return $this->serviceService->providerServicesSearch($request);
    }

    public function createFavorite(Request $request)
    {
        return $this->serviceService->createFavorite($request);
    }

    public function deleteFavorite($provider_service_id)
    {
        return $this->serviceService->deleteFavorite($provider_service_id);
    }

    public function providerServiceByFavorite()
    {
        return $this->serviceService->providerServiceByFavorite();
    }

    public function ratingProvider(Request $request)
    {
        return $this->serviceService->ratingProvider($request);
    }


}
