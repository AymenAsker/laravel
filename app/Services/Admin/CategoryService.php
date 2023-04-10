<?php

namespace App\Services\Admin;




use App\Repositories\Admin\CategoryRepository;
use Illuminate\Validation\Rule;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return $this->categoryRepository->ordered()->get();
    }

    public function create($request)
    {
        $request->validate([
            'category_name' => ['required', 'string', 'unique:categories'],
            'category_icon' => ['required', 'string', 'max:100'],
        ]);
        return $this->categoryRepository->create($request->all());
    }

    public function update($request, $slug)
    {
        $request->validate([
            'category_name' => ['required', 'string', Rule::unique('categories')->whereNot('slug',$slug)],
            'category_icon' => ['required', 'string', 'max:100'],
        ]);
        return $this->categoryRepository->updateBySlug($request->all(), $slug);
    }

    public function delete($slug)
    {
        return $this->categoryRepository->deleteBySlug($slug);
    }

    public function sort($slug,$type)
    {
        return $this->categoryRepository->sortBySlug($slug,$type);
    }
}
