<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CreateShortLinkTest extends TestCase
{
    use RefreshDatabase;
    private $token;
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

    public function testStoreShortlinkInvalidRequest()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', []);
        $response->assertStatus(302);
    }

    
    public function testStoreShortlink()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', ['url' => 'https://www.google.com']);
        
        $this->assertDatabaseHas('links', [
            'long_url' => 'https://www.google.com',
            'clicks' => 0,
            'enabled' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function testStoreLinkCustomEnding()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', [
            'url' => 'https://www.google.com',
            'custom' => 'RAID'
        ]);

        $this->assertDatabaseHas('links', [
            'short_url' => 'RAID',
            'long_url' => 'https://www.google.com',
            'clicks' => 0,
            'custom' => 1,
            'enabled' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function testStoreLinkCustomEndingFailBecauseLinkAlreadyExists()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', [
            'url' => 'https://www.google.com',
            'custom' => 'RAID'
        ]);

        $this->assertDatabaseHas('links', [
            'short_url' => 'RAID',
            'long_url' => 'https://www.google.com',
            'clicks' => 0,
            'custom' => 1,
            'enabled' => 1,
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/shorten', [
            'url' => 'https://www.google.com',
            'custom' => 'RAID'
        ]);

        $response->assertStatus(400);

        $this->assertDatabaseCount('links', 1);


    }
}
