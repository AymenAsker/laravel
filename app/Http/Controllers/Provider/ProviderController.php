<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Services\Provider\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    private ProviderService $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->providerService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->providerService->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function updateInAdmin(Request $request, $id)
    {
        return $this->providerService->updateInAdmin($request, $id);
    }

    public function update(Request $request, $id)
    {
        return $this->providerService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->providerService->delete($id);
    }
}
