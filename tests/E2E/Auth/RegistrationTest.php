<?php


namespace Tests\E2E\Auth;

use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\E2E\E2ETestCase;

class RegistrationTest extends E2ETestCase
{
    use WithFaker;

    private const MIN_PASSWORD_LENGTH = 8;

    /**
     * @param array $body
     * @param array $headers
     * @dataProvider loginDataProvider
     */
    public function testRegistration(array $body, array $headers)
    {
        $response = $this->post('register', $body, $headers);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $body['email']
        ]);
    }

    /**
     * @return array
     */
    public function loginDataProvider(): array
    {
        $faker = $this->faker(Factory::DEFAULT_LOCALE);
        $password = $faker->password(self::MIN_PASSWORD_LENGTH);
        return [
            'positive' => [
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => $password,
                    'password_confirmation' => $password
                ],
                [
                    'Accept' => 'application/json'
                ],
            ],
        ];
    }
}
