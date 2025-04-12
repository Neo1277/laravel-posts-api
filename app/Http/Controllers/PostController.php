<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return Cache::remember("posts", 60, function () {
            $listOfPosts = $this->postRepository->findAll();
            return PostResource::collection($listOfPosts);
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->postRepository->store((array)$request->validated());
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $posttId): PostResource
    {
        return Cache::remember("post.$posttId", 60, function () use ($posttId) {
            $post = $this->postRepository->findOrFail($posttId);
            return new PostResource($post);
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $postId): JsonResponse
    {
        $this->postRepository->update((array)$request->validated(), $postId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $postId): JsonResponse
    {
        $this->postRepository->delete($postId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
