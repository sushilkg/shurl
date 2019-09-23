<?php

namespace Tests\Feature;

use App\Link;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function redirect_if_not_logged_in(): void
    {
        $response1 = $this->get('/api/dashboard/all');
        $response1->assertSee('Redirecting to');

        $response2 = $this->actingAs(factory(User::class)->create(), 'api')->get('/api/dashboard/all');
        $response2->assertStatus(200);
    }

    /** @test */
    public function admin_can_see_all_links(): void
    {
        $link1 = factory(Link::class)->create();
        $link2 = factory(Link::class)->create();

        $response = $this->actingAs(factory(User::class)->create(), 'api')->get('/api/dashboard/all');

        $response->assertSee($link1->short_tag)->assertSee($link2->short_tag);
    }

    /** @test */
    public function admin_can_delete_a_link(): void
    {
        $link = factory(Link::class)->create();
        $this->actingAs(factory(User::class)->create(), 'api')->delete('/api/dashboard/delete/'.$link->short_tag);
        $this->assertSoftDeleted('links', $link->toArray());
    }

    /** @test */
    public function admin_can_see_search_by_short_or_long_link(): void
    {
        $link1 = factory(Link::class)->create();
        $response1 = $this->actingAs(factory(User::class)->create(), 'api')->get('/api/dashboard/search', ['long_url' => $link1->long_url]);
        $response1->assertSee($link1->short_tag)->assertSee($link1->id)->assertSee($link1->created_at);

        $link2 = factory(Link::class)->create();
        $response2 = $this->actingAs(factory(User::class)->create(), 'api')->get('/api/dashboard/search', ['short_tag' => $link2->short_tag]);
        $response2->assertSee($link2->short_tag)->assertSee($link2->id)->assertSee($link2->created_at);
    }

    /** @test */
    public function admin_can_see_details_of_a_link(): void
    {
        $link = factory(Link::class)->create();
        $response = $this->actingAs(factory(User::class)->create(), 'api')->get('/api/dashboard/view/'.$link->short_tag);
        $response->assertSee($link->short_tag)->assertSee($link->id)->assertSee($link->created_at);
    }
}
