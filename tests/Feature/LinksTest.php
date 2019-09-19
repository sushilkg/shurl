<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function short_link_created_and_redirects(): void
    {
        $attributes = [
            'long_url' => $this->faker->url,
            'short_tag' => $this->faker->slug,
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s')
        ];

        $this->post('/links', $attributes);
        $this->assertDatabaseHas('links', $attributes);

        $response = $this->get('/'.$attributes['short_tag']);
        $response->assertRedirect($attributes['long_url']);
    }

    /** test */
    public function test_410_for_expired_links(): void
    {
        $attributes = [
            'long_url' => $this->faker->url,
            'short_tag' => $this->faker->slug,
            'expiration_date' => $this->faker->dateTime('-1 day')->format('Y-m-d H:i:s'),
        ];

        $this->post('/links', $attributes);

        $response = $this->get('/'.$attributes['short_tag']);
        $response->assertStatus(410);
    }
}
