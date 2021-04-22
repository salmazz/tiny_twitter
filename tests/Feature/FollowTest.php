<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    protected $headers;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void {
        parent::setUp();
        \Artisan::call('passport:install');

        $user = User::create(['name' => 'salma', 'email' => 'salma@gmail.com', 'password' => bcrypt('12345678')]);
        $token =  $user->createToken('TinyTwitter')->accessToken;

        $this->headers =  [
            'Authorization' => 'Bearer '. $token
        ];
    }

    /**
     * @return void
     */
    public function test_that_follow_must_have_authorized()
    {
        $response = $this->json('POST', '/api/follow/2');

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_that_follow_not_have_unauthorized_error_for_auth()
    {
        $user = User::create(['name' => 'salma2', 'email' => 'salma2@gmail.com', 'password' => bcrypt('12345678')]);

        $response = $this->withHeaders($this->headers)->json('POST', '/api/follow/'.$user->id);

        $response->assertOk();
    }
}
