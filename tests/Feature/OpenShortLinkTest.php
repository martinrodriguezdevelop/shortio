<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OpenShortLinkTest extends TestCase
{
    use RefreshDatabase;

    protected $token;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');

        $user = User::factory()->create();
        Passport::actingAs($user);

    }

    public function testOpenShortLinkCountAndRedirect()
    {

        $response = $this->post('/api/shorten', [
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
