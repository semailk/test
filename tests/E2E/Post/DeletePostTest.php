<?php

namespace Tests\E2E\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\E2E\E2ETestCase;

class DeletePostTest extends E2ETestCase
{
    use WithFaker;

    public function testDeletePost(): void
    {
        $user = User::factory()->has(Post::factory())->create();
        $this->actingAs($user);

        $post_id = $user->posts->map(function ($post) {
            return $post->id;
        });
        $post = Post::find((int)$post_id->implode(''));
        $this->assertDatabaseHas('posts', ['image' => $post->image]);

        $response = $this->get('delete/' . (int)$post_id->implode(''));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['image' => $post->image]);
    }
}
