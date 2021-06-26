<?php


namespace Tests\E2E\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\E2E\E2ETestCase;

class LoginTest extends E2ETestCase
{

    public function testLogin(): void
    {
        $email = 'test@mail.ru';

        $user = User::factory(
            [
                'email' => $email,
                'password' => Hash::make('qweqweqwe')
            ]
        )->create();

        $response = $this->post('login', [
           'email' => $email,
           'password' => 'qweqweqwe'
        ],[
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(204);

    }
}
