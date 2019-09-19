<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    /** @test */
    public function user_must_be_logged_in_to_view_dashboard(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/dashboard');
        $response->assertRedirect();
    }
}
