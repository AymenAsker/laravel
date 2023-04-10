<?php

namespace App\Services\Provider;


use App\Http\Resources\Provider\ProviderResource;
use App\Repositories\Provider\ProviderRepository;
use Illuminate\Validation\Rule;

class ProviderService
{
    private ProviderRepository $providerRepository;


    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function index($request)
    {
        $statusA = $request->query('status_a');
        $provider = $this->providerRepository->with(['providerServices' => function ($q) {
            $q->with(['service' => function ($q) {
                $q->with('category');
            }, 'providerServicePhone', 'providerServicePrice']);
        }])->whereHas('providerServices', function ($q) use ($statusA) {
                $q->where('status_a', $statusA);
        })->get();
//        return $provider;
        return ProviderResource::collection($provider);
    }

    public function updateInAdmin($request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:40'],
            'last_name' => ['required', 'string', 'max:40'],
            'phone_number' => ['required', 'string', 'regex:/^(092|091|094)+[0-9]{7}$/',Rule::unique('providers')->ignore($id)],
        ]);
        return $this->providerRepository->update($request->all(), $id);
    }
}
