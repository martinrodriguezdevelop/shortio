<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');

    }

    public function testLoginSuccess()
    {
        $response = $this->post('/api/login', [
            'email' => 'demo@demo.com',
            'password' => 'demo'
        ]);

        $response->assertStatus(200);
    }

    public function testLoginCredentialsNotMatch()
    {
        $response = $this->post('/api/login', [
            'email' => 'demo@demo.com',
            'password' => '___unknown'
        ]);

        $response->assertStatus(401);
    }
}
