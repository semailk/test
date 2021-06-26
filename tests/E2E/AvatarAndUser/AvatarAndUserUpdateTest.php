<?php


namespace Tests\E2E\AvatarAndUser;


use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\E2E\E2ETestCase;

class AvatarAndUserUpdateTest extends E2ETestCase
{
    public function testAvatarAndUserUpdate(): void
    {
        $user = User::factory()->has(Avatar::factory())->create();
        Storage::fake('public');
        $this->actingAs($user);
        $image = UploadedFile::fake()->image('test.png');

        $response = $this->json('POST', 'user/update/' . $user->id, [
            'name' => 'Billi',
            'image' => $image
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
           'name' => 'Billi'
        ]);
        $this->assertDatabaseHas('avatars', [
            'avatar' => $user->avatar->avatar
        ]);
    }
}
