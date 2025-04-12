<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        Post::factory(5)->create(
            [
                'category_id' => Category::factory()->create()->id
            ]
        );

        $response = $this->get('/api/posts');

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'short_text',
                        'large_text',
                    ]
                ]
            ]
        );

        $this->assertCount(5, $response->json('data'));
    }

    public function testStore(): void
    {
        $category = Category::factory()->create();
        $body = [
            'title' => "Post One piece",
            'slug' => "one-piece",
            'short_text' => "texto texto",
            'large_text' => "texto texto texto",
            'category_id' => $category->id,
        ];

        $response = $this->post('/api/posts', $body);

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'short_text',
                    'large_text',
                ]
            ]
        );

        $this->assertCount(1, Post::all());
    }

    public function testShow(): void
    {
        $post = Post::factory()->create(
            [
                'category_id' => Category::factory()->create()->id
            ]
        );

        $response = $this->get('/api/posts/'.$post->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'short_text',
                    'large_text',
                ]
            ]
        );

        $this->assertEquals($post->id, $response->json('data.id'));
    }

    public function testUpdate(): void
    {
        $category = Category::factory()->create();

        $post = Post::factory()->create(
            [
                'category_id' => $category->id
            ]
        );

        $body = [
            'title' => "Post One piece",
            'slug' => "one-piece",
            'short_text' => "texto texto",
            'large_text' => "texto texto texto",
            'category_id' => $category->id,
        ];

        $response = $this->put('/api/posts/'.$post->id, $body);

        $response->assertStatus(204);

        $post->refresh();

        $this->assertEquals('Post One piece', $post->title);
        $this->assertEquals($category->id, $post->category_id);
        $this->assertEquals('texto texto', $post->short_text);
        $this->assertEquals('texto texto texto', $post->large_text);
    }

    public function testDestroy(): void
    {
        $category = Category::factory()->create();

        $post = Post::factory()->create(
            [
                'category_id' => $category->id
            ]
        );

        $response = $this->delete('/api/posts/'.$post->id);

        $response->assertStatus(204);


        $this->assertCount(0, Post::all());
    }
}
