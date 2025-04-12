<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndex(): void
    {
        Category::factory(5)->create();

        $response = $this->get('/api/categories');

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ]
        );

        $this->assertCount(5, $response->json('data'));
    }

    public function testStore(): void
    {
        $body = [
            'name' => "Manga",
        ];

        $response = $this->post('/api/categories', $body);

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                ]
            ]
        );

        $this->assertCount(1, Category::all());
    }

    public function testShow(): void
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/categories/'.$category->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                ]
            ]
        );

        $this->assertEquals($category->id, $response->json('data.id'));
    }

    public function testUpdate(): void
    {
        $category = Category::factory()->create(
            [
                'name' => "Anime",
            ]
        );

        $body = [
            'name' => "Anime y manga",
        ];

        $response = $this->put('/api/categories/'.$category->id, $body);

        $response->assertStatus(204);

        $category->refresh();

        $this->assertEquals('Anime y manga', $category->name);
    }

    public function testDestroy(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete('/api/categories/'.$category->id);

        $response->assertStatus(204);


        $this->assertCount(0, Category::all());
    }
}
