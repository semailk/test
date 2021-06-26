<?php


namespace Tests\E2E\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\E2E\E2ETestCase;

class CreatePostTest extends E2ETestCase
{
    use WithFaker;

    public function testPostCreate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');
        $title = Str::random(40);
        $response = $this->json('POST', 'store', [
            'title' => $title,
            'description' => $this->faker->text,
            'user_id' => $user->id,
            'image' => UploadedFile::fake()->image('test.png'),
        ],
            [
                'Accept' => 'application/json'
            ]);
        $image = Post::query()
            ->where('title', '=', $title)
            ->select('image')->firstOrFail();

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => $title
        ]);

        Storage::disk('public')->assertExists($image->image);
    }

}
