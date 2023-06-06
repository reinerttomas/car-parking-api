<?php

namespace Tests\Feature;

use Tests\TestCase;

class PingTest extends TestCase
{
    public function test_application_is_alive(): void
    {
        $response = $this->get('/api/v1/ping');

        $response->assertNoContent();
    }
}
