<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TweetTest extends TestCase
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
    public function test_that_tweets_must_have_authorized()
    {
        $response = $this->json('POST', '/api/tweets');

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_that_tweets_not_have_unauthorized_error_for_auth()
    {
        $response = $this->withHeaders($this->headers)->json('POST', '/api/tweets');

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_that_tweets_have_tweet_error()
    {
        $response = $this->withHeaders($this->headers)->json('POST', '/api/tweets');

        $response->assertJsonValidationErrors(['tweet']);
    }

    /**
     * @return void
     */
    public function test_that_tweets_have_tweet_error_that_more_than_140()
    {
        $text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s";
        $response = $this->withHeaders($this->headers)->json('POST', '/api/tweets', ['tweet' => $text]);

        $response->assertJsonValidationErrors(['tweet']);
    }

    /**
     * @return void
     */
    public function test_that_tweets_have_no_tweet_error_that_less_than_140()
    {
        $text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry";
        $response = $this->withHeaders($this->headers)->json('POST', '/api/tweets', ['tweet' => $text]);

        $response->assertCreated();

        $response->assertJsonMissingValidationErrors(['tweet']);
    }
}
