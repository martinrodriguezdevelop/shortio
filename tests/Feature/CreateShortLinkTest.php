<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CreateShortLinkTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');

        $user = User::factory()->create();
        Passport::actingAs($user);
    }

    public function testStoreShortlinkInvalidRequest()
    {

        $response = $this->post('/api/shorten', []);
        $response->assertStatus(302);
    }

    
    public function testStoreShortlink()
    {
        $response = $this->post('/api/shorten', ['url' => 'https://www.google.com']);

        $this->assertDatabaseHas('links', [
            'long_url' => 'https://www.google.com',
            'clicks' => 0,
            'enabled' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function testStoreLinkCustomEnding()
    {
        $response = $this->post('/api/shorten', [
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
        $response = $this->post('/api/shorten', [
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

        $response = $this->post('/api/shorten', [
            'url' => 'https://www.google.com',
            'custom' => 'RAID'
        ]);

        $response->assertStatus(400);

        $this->assertDatabaseCount('links', 1);


    }
}
