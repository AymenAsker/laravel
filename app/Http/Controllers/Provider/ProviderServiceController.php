<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\Provider\ProviderServiceService;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{

    private ProviderServiceService $providerServiceService;

    public function __construct(ProviderServiceService $providerServiceService)
    {
        $this->providerServiceService = $providerServiceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->providerServiceService->index();
    }

    public function servicesByCategory(Request $request)
    {
        return $this->providerServiceService->servicesByCategory($request);
    }

    public function getAuthProviderService()
    {
        return $this->providerServiceService->getAuthProviderService();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->providerServiceService->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->providerServiceService->update($request, $id);
    }

    public function updateStatusA(Request $request, $id)
    {
        return $this->providerServiceService->updateStatusA($request, $id);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->providerServiceService->updateStatus($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->providerServiceService->delete($id);
    }
}
