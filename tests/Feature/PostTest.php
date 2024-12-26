<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPostScopedBindingReturnCorrectPost()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $response = $this->get("/custom_key_and_scoping/controller/user/{$user->email}/post/{$post->slug}");

        // pastikan $response mengembalikan status 200
        $response->assertStatus(200);

        // pastikan konten sesuai
        $response->assertJson([
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'post' => [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'content' => $post->content,
                ]
            ]
        ]);
    }
}
