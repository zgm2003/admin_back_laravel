<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;

final class HealthTest extends TestCase
{
    public function test_api_health_endpoint_returns_a_standard_success_payload(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response
            ->assertOk()
            ->assertHeader('X-Request-Id')
            ->assertJsonPath('data.status', 'ok')
            ->assertJsonPath('data.api_version', 'v1');
    }

    public function test_admin_api_group_has_its_own_route_scope(): void
    {
        $response = $this->getJson('/api/v1/admin/health');

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'ok')
            ->assertJsonPath('data.client', 'admin');
    }

    public function test_app_api_group_has_its_own_route_scope(): void
    {
        $response = $this->getJson('/api/v1/app/health');

        $response
            ->assertOk()
            ->assertJsonPath('data.status', 'ok')
            ->assertJsonPath('data.client', 'app');
    }

    public function test_missing_api_endpoint_returns_a_standard_error_payload(): void
    {
        $response = $this->getJson('/api/v1/missing-route');

        $response
            ->assertNotFound()
            ->assertJsonPath('code', 'NOT_FOUND')
            ->assertJsonStructure([
                'message',
                'code',
                'trace_id',
            ]);
    }
}
