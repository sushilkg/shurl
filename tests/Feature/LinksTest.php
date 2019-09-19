<?php

namespace Tests\Feature;

use App\Link;
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
        $expiration_date = $this->faker->dateTime('-1 day')->format('Y-m-d H:i:s');
        $short_tag = $this->faker->slug;

        factory(Link::class)->create(['expiration_date' => $expiration_date, 'short_tag' => $short_tag]);

        $response = $this->get('/'.$short_tag);
        $response->assertStatus(410);
    }

    /** test */
    public function test_410_for_deleted_links(): void
    {
        $link = factory(Link::class)->create();
        $link->delete();

        $response = $this->get('/'.$link['short_tag']);
        $response->assertStatus(410);
    }

    /** @test */
    public function always_require_long_url(): void
    {
        $this->post('/links')->assertSessionHasErrors();
    }

    /** @test */
    public function provided_short_tag_must_be_unique(): void
    {
        $attributes = [
            'long_url' => 'http://gooddomain.com',
            'short_tag' => $this->faker->slug
        ];

        $this->post('/links', $attributes);
        $response = $this->post('/links', $attributes);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function short_tag_can_be_auto_generated(): void
    {
        $link = factory(Link::class)->create(['short_tag' => null]);
        $this->assertNotEmpty($link->short_tag);

        $attributes = ['long_url' => $this->faker->url];
        $response = $this->post('/links', $attributes);
        $response->assertSessionDoesntHaveErrors();
    }

    /** @test */
    public function hit_increases_on_link_visit(): void
    {
        $link = factory(Link::class)->create(['hits' => 0, 'expiration_date' => null]);

        $this->get('/'.$link->short_tag);
        $updatedLink = Link::where(['short_tag' => $link->short_tag])->first();
        $this->assertEquals(1, $updatedLink->hits);
    }

    /** @test */
    public function blacklisted_url_can_not_be_shortened(): void
    {
        $this->post('/links', ['long_url' => 'https://baddomain.com'])->assertSessionHasErrors();
        $this->post('/links', ['long_url' => 'https://gooddomain.com'])->assertSessionHasNoErrors();
    }

    //admin can search by short and long url
    //support data set that fit into memory
}
