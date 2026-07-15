<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CorsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_v1_responses_include_cors_headers_for_browser_clients(): void
    {
        $response = $this->getJson('/api/v1/ustazes', [
            'Origin' => 'http://localhost:3000',
        ]);

        $response->assertOk();
        $response->assertHeader('Access-Control-Allow-Origin', '*');
    }

    public function test_api_v1_preflight_options_request_is_allowed(): void
    {
        $response = $this->withHeaders([
            'Origin' => 'http://localhost:3000',
            'Access-Control-Request-Method' => 'GET',
        ])->options('/api/v1/content');

        $response->assertSuccessful();
        $response->assertHeader('Access-Control-Allow-Origin', '*');
        $response->assertHeader('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS');
    }
}
