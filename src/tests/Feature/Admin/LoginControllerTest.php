<?php

namespace Tests\Feature\Admin;

use App\Jobs\RunInitialSetup;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_admin_login_with_valid_credentials(): void
    {
        $this->setUpFaker();
        $email = $this->faker->email();
        $name = $this->faker->name();
        $password = 'password';
        // Run Initial set up via sync 
        (new RunInitialSetup($email, $password, $name))->handle();
        $admin = Admin::where('email', $email)->first();

        $response = $this->post('api/admin/auth/login', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'access_token'
                ]
            ])
            ->assertJsonPath('data.name', $name)
            ->assertJsonPath('data.email', $email);
    }

    public function test_admin_login_with_invalid_credentials(): void
    {
        $email = $this->faker->email();
        $name = $this->faker->name();
        $password = 'password';
        // Run Initial set up via sync 
        (new RunInitialSetup($email, $password, $name))->handle();
        $admin = Admin::where('email', $email)->first();

        $response = $this->post('api/admin/auth/login', [
            'email' => $email,
            'password' => 'adminpassword'
        ]);
        $response_object = json_decode($response->getContent());
        $response->assertStatus(401);
        $this->assertEquals('Invalid email or password!', $response_object->message);
        $this->assertEquals('Unauthenticated', $response_object->error);
    }

    /**
     * @dataProvider incompleteAdminParameters
     *
     * @return void
     */
    public function test_admin_login_with_incomplete_parameters(array $payload)
    {
        $response = $this->post('api/admin/auth/login', $payload);
        $response_object = json_decode($response->getContent());
        $this->assertNotNull($response_object->errors);
    }

    /**
     *
     * @return array
     */
    public static function incompleteAdminParameters(): array
    {
        return [
            'No admin email provided' => [[
                'password' => 'password'
            ]],
            'No admin password provided' => [[
                'email' => 'email'
            ]],
            'Both admin email and password not provided' => [[]]
        ];
    }
}
