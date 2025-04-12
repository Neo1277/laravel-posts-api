<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepository implements CrudRepositoryInterface
{
    public function findAll(): Collection
    {
        return Post::all();
    }

    public function findOrFail(int $id): Model
    {
        return Post::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Post::query()
            ->create($data);
    }

    public function update(array $data, int $id): void
    {
        Post::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}