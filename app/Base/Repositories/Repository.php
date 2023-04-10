<?php

namespace App\Base\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Repository implements RepositoryInterface
{
    protected Model $model;

    public function auth()
    {
        return Auth::guard('sanctum')->user();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function ordered()
    {
        return $this->model->ordered();
    }

    public function with(array $tables)
    {
        return $this->model->with($tables);
    }
    public function join($table,$first, $operator = null,$second = null,$type = 'inner',$where = false)
    {
        return $this->model->join($table, $first, $operator, $second, $type, $where);
    }
    public function where(array $tables)
    {
        return $this->model->where($tables);
    }

    public function findOrFail($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        return $model->update($data);
    }

    public function delete($id): ?bool
    {
        $model = $this->model->findOrFail($id);
        return $model->delete($id);
    }

    public function findBySlug($slug): ?Model
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function updateBySlug(array $data, $slug)
    {
        $model = $this->model->where('slug', $slug)->firstOrFail();
        $model->update($data);
        return $model;
    }

    public function deleteBySlug($slug)
    {
        $model = $this->model->where('slug', $slug)->firstOrFail();
        $model->delete();
        return $model;
    }

    public function sortBySlug($slug,$type)
    {
        $model = $this->model->where('slug', $slug)->firstOrFail();

        if ($type == 'up') {
            $model->moveOrderUp();
        } else {
            $model->moveOrderDown();
        }
        return $model;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }


}
