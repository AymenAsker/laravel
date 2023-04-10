<?php

namespace App\Services\Provider;


use App\Http\Resources\Provider\AuthProviderServiceResource;
use App\Repositories\Admin\ServiceRepository;
use App\Repositories\Provider\ProviderServiceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProviderServiceService
{
    private ProviderServiceRepository $providerServiceRepository;
    private ServiceRepository $serviceRepository;

    public function __construct(ProviderServiceRepository $providerServiceRepository,ServiceRepository $serviceRepository)
    {
        $this->providerServiceRepository = $providerServiceRepository;

        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        return $this->providerServiceRepository->with(['service' => function ($q) {
            $q->with('category');
        }, 'providerServicePhone', 'providerServicePrice'])->get();
    }

    public function servicesByCategory($request)
    {
        $serviceId = $this->providerServiceRepository->auth()->providerServices()->pluck('service_id')->toArray();
        return $this->serviceRepository->where(['category_id' => $request->query('category_id')])->whereNotIn('id', $serviceId)->with(['category'])->get();
    }


    public function getAuthProviderService()
    {
        $providerServiceByAuth = $this->providerServiceRepository->auth()->providerServices()
            ->with(['service' => function ($q) {
                $q->with('category');
            }, 'providerServicePhone', 'providerServicePrice','ratings'])
            ->withAvg('ratings','rating')
            ->withCount('ratings')
            ->orderBy('ratings_avg_rating' , 'desc')
            ->orderBy('ratings_count' , 'desc')
            ->get();
//        return $providerServiceByAuth;
        return AuthProviderServiceResource::collection($providerServiceByAuth);
    }

    public function create($request)
    {

        $request->validate([
            'service' => ['required', 'exists:services,id'],
            'name_brand' => ['required', 'string', 'max:30'],
            'day_of_week' => ['required', 'string', 'max:50'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'phone_number' => ['required', 'array'],
            'phone_number.*' => ['required', 'string', 'regex:/^(092|091|094)+[0-9]{7}$/'],
            'price_number' => ['required', 'int', 'regex:/^(\d+|\d+(\.\d{1,2})?|(\.\d{1,2}))$/'],
            'details' => ['required', 'string','min:10', 'max:350'],
        ]);
        DB::beginTransaction();
        try {
            $providerService = $this->providerServiceRepository->create([
                'provider_id' => $this->providerServiceRepository->auth()->id,
                'service_id' => $request->post('service'),
                'name_brand' => $request->post('name_brand'),
                'day_of_week' => $request->post('day_of_week'),
                'start_time' => $request->post('start_time'),
                'end_time' => $request->post('end_time'),
                'details' => $request->post('details'),
            ]);
            $phone_number = $request->post('phone_number');
            if ($phone_number) {
                foreach ($phone_number as $phone) {
                    $providerService->providerServicePhone()->create([
                        'phone_number' => $phone
                    ]);
                }
            }
            $price_number = $request->post('price_number');
            if ($price_number) {
                $providerService->providerServicePrice()->create([
                    'price_number' => $price_number
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $providerService->load(['providerServicePhone', 'providerServicePrice']);
    }

    public function update($request, $slug)
    {

        $request->validate([
            'name_brand' => ['required', 'string', 'max:30'],
            'day_of_week' => ['required', 'string', 'max:50'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'phone_number' => ['required', 'array'],
            'phone_number.*' => ['required', 'string', 'regex:/^(092|091|094)+[0-9]{7}$/'],
            'price_number' => ['required', 'int', 'regex:/^(\d+|\d+(\.\d{1,2})?|(\.\d{1,2}))$/'],
            'details' => ['required', 'string','min:10', 'max:350'],
        ]);
        DB::beginTransaction();
        try {
            $providerService = $this->providerServiceRepository->updateBySlug([
                'name_brand' => $request->post('name_brand'),
                'day_of_week' => $request->post('day_of_week'),
                'start_time' => $request->post('start_time'),
                'end_time' => $request->post('end_time'),
                'details' => $request->post('details'),
                'status_a' => 0,
            ],$slug);

            $providerService->providerServicePhone()->delete();
            $providerService->providerServicePrice()->delete();

            $phone_number = $request->post('phone_number');
            if ($phone_number) {
                foreach ($phone_number as $phone) {
                    $providerService->providerServicePhone()->create([
                        'phone_number' => $phone
                    ]);
                }
            }
            $price_number = $request->post('price_number');
            if ($price_number) {
                $providerService->providerServicePrice()->create([
                    'price_number' => $price_number
                ]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $providerService->load(['providerServicePhone', 'providerServicePrice']);

    }

    public function updateStatusA($request, $slug)
    {
        $request->validate([
            'status_a' => ['required', 'in:0,1'],
        ]);

        return $this->providerServiceRepository->updateBySlug(['status_a' => $request->post('status_a')], $slug);
    }

    public function updateStatus($request, $slug)
    {
        $request->validate([
            'status' => ['required', 'in:0,1'],
        ]);

        return $this->providerServiceRepository->updateBySlug(['status' => $request->post('status')], $slug);
    }

    public function delete($slug)
    {
        $providerService = $this->providerServiceRepository->findBySlug($slug);
        $providerService->providerServicePhone()->delete();
        $providerService->providerServicePrice()->delete();
        $providerService->delete();
        return $providerService;
    }
}
