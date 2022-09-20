<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function homeにアクセスしたら公開済みの投稿のリストが表示される()
    {
        [$post1, $post2, $post3] = Post::factory(3)->create();

        $this->get(route('home'))->assertRedirect(route('login'));

        User::factory()->create();
        $user = User::first();
        $this->actingAs($user)->get(route('home'))
            ->assertOk()
            ->assertViewIs('home')
            ->assertSeeInOrder([$post1->title, $post1->body, $post2->title, $post2->body, $post3->title, $post3->body]);
    }

    /** @test */
    function 非公開の投稿は表示しない()
    {
        [$published_post1, $published_post2] = Post::factory(2)->create();
        [$draft_post1, $draft_post2] = Post::factory(2)->draft()->create();

        User::factory()->create();
        $user = User::first();
        $this->actingAs($user)->get(route('home'))
            ->assertOk()
            ->assertViewIs('home')
            ->assertSeeInOrder([$published_post1->title, $published_post1->body, $published_post2->title, $published_post2->body])
            ->assertDontSee($draft_post1->title)
            ->assertDontSee($draft_post1->body)
            ->assertDontSee($draft_post2->title)
            ->assertDontSee($draft_post2->body);
    }
}
