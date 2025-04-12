<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CrudRepositoryInterface
{
    public function findAll(): Collection
    {
        return Category::all();
    }

    public function findOrFail(int $id): Model
    {
        return Category::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Category::query()
            ->create($data);
    }

    public function update(array $data, int $id): void
    {
        Category::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}