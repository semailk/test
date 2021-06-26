<?php


namespace Tests\E2E\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\E2E\E2ETestCase;

class UpdatePostTest extends E2ETestCase
{
    use WithFaker;

    public function testPostUpdate(): void
    {
        $user = User::factory()->has(Post::factory()->count(1))->create();
        $post_id = $user->posts->map(function ($post) {
            return $post->id;
        });
        $this->actingAs($user);

        Storage::fake('public');
        $data = [
            'title' => Str::random(40),
            'description' => $this->faker->text(150),
            'image' => UploadedFile::fake()->image('test.png')
        ];

        $response = $this->json('POST', 'update/' . $post_id[0],
            $data, [
                'Accept' => 'application/json'
            ]
        );

        $post = Post::query()->where('title', $data['title'])->firstOrFail();

        $response->assertRedirect();
        $response->assertStatus(302);
        $this->assertDatabaseHas('posts', ['title' => $data['title']]);
        Storage::disk('public')->assertExists($post->image);

    }
}
