<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithoutMiddleware;

    public function testRegister(): void
    {
        $password = Hash::make(md5(Str::random(5)));
        $response = $this->post('/register', [
            'name' => Str::random(8),
            'phone' => random_int(1000000, 9999999),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => 'user'
        ]);

        $this->assertEquals(302, $response->status());
    }

    public function testLogin():void
    {
        $password = Hash::make('qweqweqwe');
        $phone = random_int(1000000, 9999999);
        $response = $this->post('/register', [
            'name' => Str::random(8),
            'phone' => $phone,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => 'user'
        ]);
        $this->assertEquals(302, $response->status());

         $this->post('login', [
            'password' => $password,
            'phone' => $phone
        ]);

        $this->assertTrue(Auth::check());
    }
}
