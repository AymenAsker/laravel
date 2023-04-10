<?php

namespace App\Services\Public;


use App\Http\Resources\Provider\AuthFavoriteResource;
use App\Http\Resources\Provider\ProviderServiceResource;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ServiceRepository;
use App\Repositories\Provider\ProviderServiceRepository;


class ServiceService
{
    private CategoryRepository $categoryRepository;
    private ServiceRepository $serviceRepository;
    private ProviderServiceRepository $providerServiceRepository;

    public function __construct(CategoryRepository $categoryRepository, ServiceRepository $serviceRepository, ProviderServiceRepository $providerServiceRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->serviceRepository = $serviceRepository;
        $this->providerServiceRepository = $providerServiceRepository;
    }

    public function category()
    {
        return $this->categoryRepository->ordered()->get();
    }

    public function serviceByCategory($slug)
    {
        return $this->categoryRepository->findBySlug($slug)->services()->ordered()->get();
    }

    public function providerServiceByService($slug)
    {
        $providerServiceByService = $this->serviceRepository->findBySlug($slug)->providerServices()
            ->with(['provider:id,first_name,last_name', 'service' => function ($q) {
                $q->with('category');
            }, 'providerServicePhone', 'providerServicePrice', 'favorites', 'ratings'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->status()
            ->orderBy('ratings_avg_rating', 'desc')
            ->orderBy('ratings_count', 'desc')
            ->get();
//        return $providerServiceByService;
        return ProviderServiceResource::collection($providerServiceByService);
    }

    public function providerServicesSearch($request)
    {
        $search = $request->query('search');


        $providerServiceByService = $this->providerServiceRepository
            ->with(['provider:id,first_name,last_name', 'service' => function ($q) use ($search) {
                $q->with('category')->where('service_name', 'LIKE', "%$search%");
            }, 'providerServicePhone', 'providerServicePrice', 'favorites', 'ratings'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->whereHas('service')
//            ->orWhere('details', 'LIKE', "%$search%")
            ->status()
            ->orderBy('ratings_avg_rating', 'desc')
            ->orderBy('ratings_count', 'desc')
            ->get();
        return $providerServiceByService;
//        return ProviderServiceResource::collection($providerServiceByService);
    }

    public function providerServiceByFavorite()
    {
        $providerServiceByFavorite = $this->providerServiceRepository->auth()->favorites()
            ->with(['providerService' => function ($q) {
                $q->with(['provider:id,first_name,last_name', 'service' => function ($q) {
                    $q->with('category');
                }, 'providerServicePhone', 'providerServicePrice', 'favorites', 'ratings'])
                    ->withAvg('ratings', 'rating')
                    ->withCount('ratings')
                    // ->status()
                    ->orderBy('ratings_avg_rating', 'desc')
                    ->orderBy('ratings_count', 'desc');
            }])->whereHas('providerService' ,function ($q) {
                $q->status();
            } )->get();
//        return $providerServiceByFavorite;
        return AuthFavoriteResource::collection($providerServiceByFavorite);
    }

    public function createFavorite($request)
    {
        $request->validate([
            'provider_service_id' => ['required', 'exists:provider_services,id'],
        ]);
        return $this->providerServiceRepository->auth()->favorites()->create(['provider_service_id' => $request->post('provider_service_id')]);
    }

    public function deleteFavorite($provider_service_id)
    {
        return $this->providerServiceRepository->auth()->favorites()->where('provider_service_id', $provider_service_id)->delete();
    }

    public function ratingProvider($request)
    {
        $request->validate([
            'provider_service_id' => ['required', 'exists:provider_services,id'],
        ]);
        return $this->providerServiceRepository->auth()->ratings()->UpdateOrCreate([
            'provider_service_id' => $request->post('provider_service_id')
        ], [
            'rating' => $request->post('rating')
        ]);
    }
}
