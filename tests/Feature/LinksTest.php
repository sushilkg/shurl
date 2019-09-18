<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function link_saved_in_database(): void
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'long_url' => $this->faker->url,
            'short_tag' => $this->faker->slug,
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s'),
            'hits' => $this->faker->randomNumber()
        ];

        $this->post('/links', $attributes);

        $this->assertDatabaseHas('links', $attributes);
    }
}
