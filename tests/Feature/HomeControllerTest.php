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
            ->assertSee($post1->title)
            ->assertSee($post1->body)
            ->assertSee($post2->title)
            ->assertSee($post2->body)
            ->assertSee($post3->title)
            ->assertSee($post3->body);
    }
}
