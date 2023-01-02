<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OpenShortLinkTest extends TestCase
{
    use RefreshDatabase;

    protected $token;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');

        $client = Client::first();
        $response = $this->post('/oauth/token',[
            "client_id" => $client->id,
            "client_secret" => $client->secret,
            "grant_type" => "client_credentials"
        ]);

        $this->token = $response->json()['access_token'];

    }

    public function testOpenShortLinkCountAndRedirect()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', [
            'url' => 'https://www.google.com',
            'custom' => 'RAID'
        ]);

        $response->assertStatus(200);

        $response = $this->get('/RAID');

        $this->assertDatabaseHas('links', [
            'short_url' => 'RAID',
            'long_url' => 'https://www.google.com',
            'clicks' => 1,
            'custom' => 1,
            'enabled' => 1,
        ]);

        $response->assertStatus(301);
    }

    public function testTryToGetNonExistentLink()
    {
        $response = $this->get('/TEST');

        $response->assertStatus(403);
    }
}
