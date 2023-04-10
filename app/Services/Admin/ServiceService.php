<?php

namespace App\Services\Admin;


use App\Repositories\Admin\ServiceRepository;
use Illuminate\Validation\Rule;

class ServiceService
{
    private ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        return $this->serviceRepository->with(['category'])->ordered()->get();
    }

    public function servicesByCategory($request)
    {
        return $this->serviceRepository->where(['category_id' => $request->query('category_id')])->with(['category'])->get();
    }

    public function create($request)
    {
        $request->validate([
            'service_name' => ['required', 'string', Rule::unique('services')->where('category_id', $request->category_id)],
            'category_id' => ['required', 'exists:categories,id'],
            'service_icon' => ['required', 'string', 'max:100'],
        ]);
        return $this->serviceRepository->create($request->all())->load('category');
    }

    public function update($request, $slug)
    {
        $request->validate([
            'service_name' => ['required', 'string', Rule::unique('services')->where('category_id', $request->category_id)->whereNot('slug', $slug)],
            'category_id' => ['required', 'exists:categories,id'],
            'service_icon' => ['required', 'string', 'max:100'],
        ]);
        return $this->serviceRepository->updateBySlug($request->all(), $slug)->load('category');
    }

    public function delete($slug)
    {
        return $this->serviceRepository->deleteBySlug($slug);
    }

    public function sort($slug,$type)
    {
        return $this->serviceRepository->sortBySlug($slug,$type);
    }
}
