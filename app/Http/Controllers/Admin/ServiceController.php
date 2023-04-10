<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ServiceService;
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
    public function index()
    {
        return $this->serviceService->index();
    }

    public function servicesByCategory(Request $request)
    {
        return $this->serviceService->servicesByCategory($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->serviceService->create($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->serviceService->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->serviceService->delete($id);
    }

    public function sort($slug,$type)
    {
        return $this->serviceService->sort($slug,$type);
    }
}
