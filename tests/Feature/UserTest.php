<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
        \Artisan::call('passport:install');
    }

    /**
     * @return void
     */
    public function test_that_users_count_is_zero()
    {
        $this->assertCount(0, User::all());
    }

    /**
     * @return void
     */
    public function test_that_users_have_errors_for_register()
    {
        $response = $this->json('POST', '/api/auth/register', []);

        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * @return void
     */
    public function test_that_users_dont_have_error_for_register_name()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'name' => 'salma',
        ]);

        $response->assertJsonMissingValidationErrors('name');

        $response->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * @return void
     */
    public function test_that_users_have_error_for_wrong_date_in_register()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'date_of_birth' => 'test',
        ]);

        $response->assertJsonValidationErrors(['date_of_birth']);
    }

    /**
     * @return void
     */
    public function test_that_users_registered_successfully()
    {
        $response = $this->json('POST', '/api/auth/register', [
            'name' => 'salma',
            'email' => 'salmamehanny@gmail.com',
            'password' => '12345678',
        ]);

        $response->assertCreated();

        $this->assertCount(1, User::all());
    }


    /**
     * @return void
     */
    public function test_that_users_have_errors_for_login()
    {
        $response = $this->json('POST', '/api/auth/login', []);

        $response->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * @return void
     */
    public function test_that_users_logged_successfully()
    {
        $email = 'salmamehanny@gmail.com';
        $password = '12345678';

        $this->json('POST', '/api/auth/register', [
            'name' => 'salma',
            'email' => $email,
            'password' => $password,
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertOk();
    }
}
