<?php

namespace App\Base\Repositories;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    public function auth();
    public function all();
    public function ordered();
    public function with(array $tables);
    public function join($table, $first, $operator, $second, $type, $where);
    public function where(array $tables);
    public function findOrFail($id): ?Model;
    public function create(array $data): ?Model;
    public function update(array $data,$id);
    public function delete($id): ?bool;

    // slug -----------------------------------
    public function findBySlug($slug): ?Model;
    public function updateBySlug(array $data,$slug);
    public function deleteBySlug($slug);
    public function sortBySlug($slug,$type);
}
